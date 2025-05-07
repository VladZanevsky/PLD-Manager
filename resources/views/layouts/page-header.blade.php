<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@section('title')Главная@show</h1>
            </div>
            @if (\Diglactic\Breadcrumbs\Breadcrumbs::exists())
                {{ \Diglactic\Breadcrumbs\Breadcrumbs::render() }}
            @endif
        </div>
    </div><!-- /.container-fluid -->
</section>
