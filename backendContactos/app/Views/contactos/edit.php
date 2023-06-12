<?=$head?>
<?=$navbar?>

<div class="container mt-2">
    <h2>Editar Contacto</h2>

    <?php if (session()->has('errorEditar')) : ?>
    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
        <?= session('errorEditar') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="card-title">Ingresa los datos de contacto:</div>
            <div class="card-text">
                <form class="row g-3" action="<?= site_url('/actualizar/'.$contacto['id']) ?>"
                    enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id" value="<?=$contacto['id']?>">

                    <div class="col-md-6">
                        <label class="form-label" for="nombre">Nombre:</label>
                        <input class="form-control" type="text" name="nombre" id="nombre"
                            value="<?= $contacto['nombre']?>">
                        <p class="text-danger"><?=session('errors.nombre')?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="apellidos">Apellidos:</label>
                        <input class="form-control" type="text" name="apellidos" id="apellidos"
                            value="<?= $contacto['apellidos'] ?>">
                        <p class="text-danger"><?=session('errors.apellidos')?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="telefono">Teléfono:</label>
                        <input class="form-control" type="text" name="telefono" id="telefono"
                            value="<?= $contacto['telefono'] ?>">
                        <p class="text-danger"><?=session('errors.telefono')?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="correo">Correo:</label>
                        <input class="form-control" type="email" name="correo" id="correo"
                            value="<?= $contacto['correo'] ?>">
                        <p class="text-danger"><?=session('errors.correo')?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="foto">Foto:</label>
                        <input class="form-control" type="file" name="foto" id="foto" value="<?= $contacto['foto'] ?>">
                        <img class="img-thumbnail" src="<?= $contacto['foto'] ? $urlPath.''.$contacto['foto'] : $urlImageDefault  ?>" width="100"
                            alt="...">
                        <p class="text-danger"><?=session('errors.foto')?></p>

                    </div>

                    <div class="col-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-success me-md-2" type="submit">Guardar</button>
                            <a class="btn btn-danger" href="<?= site_url('/') ?>">Cancelar</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?=$footer?>