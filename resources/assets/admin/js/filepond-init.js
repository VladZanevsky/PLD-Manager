import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

document.addEventListener("DOMContentLoaded", async () => {
    if (typeof FilePond === "undefined") {
        console.error("FilePond не загружен!");
        return;
    }

    FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const filePondElements = document.querySelectorAll('.file-pond');

    const loadFile = async (source) => {
        try {
            const response = await fetch(source);
            if (!response.ok) throw new Error(`Не удалось загрузить файл: ${source}`);
            const blob = await response.blob();
            const fileName = source.split('/').pop();
            const fileType = source.endsWith('.mp4') ? 'video/mp4' : 'image/jpeg';
            return {
                source: source.replace(window.location.origin + '/storage/', ''),
                options: { type: 'local', file: new File([blob], fileName, { type: fileType }) }
            };
        } catch (error) {
            console.error(error);
            return null;
        }
    };

    const updateHiddenFields = (pond, container, isPhotoField) => {
        const existingFields = container.querySelectorAll(`input[type="hidden"][name="${isPhotoField ? 'photos[]' : 'videos[]'}"]`);
        existingFields.forEach(field => field.remove());
        pond.getFiles().forEach(file => {
            const path = file.serverId || file.source;
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = isPhotoField ? 'photos[]' : 'videos[]';
            hiddenField.value = path;
            container.appendChild(hiddenField);
        });
    };

    for (const inputElement of filePondElements) {
        const isPhotoField = inputElement.name === 'photos[]';
        const isVideoField = inputElement.name === 'videos[]';
        const container = inputElement.parentElement;

        let filesData = [];
        if (inputElement.dataset.files) {
            try {
                const parsedData = JSON.parse(inputElement.dataset.files);
                filesData = await Promise.all(parsedData.map(file => loadFile(file.source)));
                filesData = filesData.filter(Boolean); // Убираем null
            } catch (e) {
                console.error("Ошибка при разборе JSON data-files:", e);
            }
        }

        const pond = FilePond.create(inputElement, {
            allowMultiple: true,
            acceptedFileTypes: isPhotoField ? ['image/*'] : isVideoField ? ['video/*'] : ['image/*', 'video/*'],
            files: filesData,
            server: {
                process: {
                    url: '/file/upload',
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    onload: response => JSON.parse(response).path
                },
                revert: {
                    url: '/file/delete',
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                }
            },
            oninit: () => updateHiddenFields(pond, container, isPhotoField),
            onaddfile: () => updateHiddenFields(pond, container, isPhotoField),
            onremovefile: () => updateHiddenFields(pond, container, isPhotoField),
            labelIdle: isPhotoField ? 'Перетащите фото сюда' : 'Перетащите видео сюда',
            labelFileProcessing: 'Загрузка...'
        });
    }
});
