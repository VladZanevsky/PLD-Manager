<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnimalPetRequest;
use App\Models\Animal;
use App\Models\AnimalPet;
use App\Models\Photo;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnimalPetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = __('messages.animal_pet.plural');

        $animal_pets = AnimalPet::query()->orderBy('created_at', 'desc');
        $animal_pets = $animal_pets->paginate(config('settings.paginate'));

        return view('admin.animal_pet.index', compact(
            'title',
            'animal_pets',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = __('messages.animal_pet.create');

        $animals = Animal::query()->orderBy('name')->get();
        $users = User::query()->orderBy('lastname')->get();

        return view('admin.animal_pet.create', compact(
            'title',
            'animals',
            'users',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnimalPetRequest $request)
    {
        $animalPet = AnimalPet::createAnimalPet($request);

        if (!$animalPet) {
            return redirect()->route('admin.animal-pets.index')
                ->with('error', __('messages.animal_pet.error.store'));
        }

        $this->syncFiles($request, $animalPet, 'photos');
        $this->syncFiles($request, $animalPet, 'videos');

        return redirect()->route('admin.animal-pets.index')
            ->with('success', __('messages.animal_pet.success.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AnimalPet $animal_pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnimalPet $animal_pet)
    {
        $title = __('messages.animal_pet.edit', ['animal_pet' => $animal_pet->name]);

        $animals = Animal::query()->orderBy('name')->get();
        $users = User::query()->orderBy('lastname')->get();

        $photosFiles = $this->prepareFileData($animal_pet->photos);
        $videosFiles = $this->prepareFileData($animal_pet->videos);


        return view('admin.animal_pet.edit', compact(
            'title',
            'animal_pet',
            'animals',
            'users',
            'photosFiles',
            'videosFiles',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnimalPetRequest $request, AnimalPet $animal_pet)
    {
        $result = AnimalPet::updateAnimalPet($request, $animal_pet);

        $redirect = to_route('admin.animal-pets.index');

        $this->syncFiles($request, $animal_pet, 'photos');
        $this->syncFiles($request, $animal_pet, 'videos');

        if (!$result) {
            return $redirect->with('error', __('messages.animal_pet.error.update'));
        }

        return $redirect->with('success', __('messages.animal_pet.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnimalPet $animal_pet)
    {
        $is_destroyed = DB::transaction(function () use ($animal_pet) {
            // Удаляем связанные фото
            foreach ($animal_pet->photos as $photo) {
                if (Storage::disk('public')->exists($photo->path)) {
                    Storage::disk('public')->delete($photo->path);
                }
                $photo->deletePhoto($photo);
            }

            // Удаляем связанные видео
            foreach ($animal_pet->videos as $video) {
                if (Storage::disk('public')->exists($video->path)) {
                    Storage::disk('public')->delete($video->path);
                }
                $video->deleteVideo($video);
            }

            // Удаляем саму сущность
            return AnimalPet::deleteAnimalPet($animal_pet) !== null;
        });

        $redirect = redirect()->back();

        if ($is_destroyed === null)
        {
            return $redirect->with('error', __('messages.animal_pet.error.destroy'));
        }

        return $redirect->with('success', __('messages.animal_pet.success.destroy'));
    }

    protected function prepareFileData($files)
    {
        return $files->map(fn($file) => [
            'source' => asset('storage/' . $file->path),
            'options' => [
                'type' => 'local',
                'file' => [
                    'name' => basename($file->path),
                    'type' => mime_content_type(storage_path('app/public/' . $file->path))
                ]
            ]
        ])->toArray();
    }

    protected function syncFiles($request, $animalPet, $type)
    {
        $inputKey = $type === 'photos' ? 'photos' : 'videos';
        $model = $type === 'photos' ? Photo::class : Video::class;
        $existingFiles = $animalPet->$type->pluck('path')->toArray();
        $newFilePaths = array_filter($request->input($inputKey, []), 'is_string');

        // Удаление файлов
        $filesToDelete = array_diff($existingFiles, $newFilePaths);
        foreach ($filesToDelete as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $animalPet->$type()->where('path', $path)->delete();
        }

        // Добавление новых файлов
        if ($request->has($inputKey)) {
            foreach ($newFilePaths as $path) {
                if (is_string($path) && Storage::disk('public')->exists($path) && !in_array($path, $existingFiles)) {
                    $newPath = "animal_pets/$type/" . basename($path);
                    Storage::disk('public')->move($path, $newPath);
                    $model::createFromPath($newPath, $animalPet->id, $type === 'photos' ? AnimalPet::class : null);
                }
            }
        }
    }
}
