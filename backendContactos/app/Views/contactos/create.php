<?=$head?>
<?=$navbar?>

<div class="container mt-2">
    <h2>Crear Contacto</h2>

    <?php if (session()->has('errorCrear')) : ?>
    <div class="alert alert-danger  alert-dismissible fade show" role="alert">
        <?= session('errorCrear') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="card-title">Ingresa los datos de contacto:</div>
            <div class="card-text">
                <form class="row g-3 needs-validation" action="<?= site_url('/guardar') ?>"
                    enctype="multipart/form-data" method="post" novalidate>
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" value="<?=old('nombre')?>" class="form-control" name="nombre" id="nombre"
                            required>
                        <p class="text-danger"><?=session('errors.nombre')?></p>
                    </div>
                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" value="<?=old('apellidos')?>" class="form-control" name="apellidos"
                            id="apellidos">
                        <p class="text-danger"><?=session('errors.apellidos')?></p>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Telelefono</label>
                        <input type="text" value="<?=old('telefono')?>" class="form-control" name="telefono"
                            id="telefono" required>
                        <p class="text-danger"><?=session('errors.telefono')?></p>
                    </div>
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" value="<?=old('correo')?>" class="form-control" name="correo" id="correo"
                            required>
                        <p class="text-danger"><?=session('errors.correo')?></p>
                    </div>
                    <div class="col-md-6">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" name="foto" id="foto">
                        <p class="text-danger"><?=session('errors.foto')?></p>
                    </div>
                    <div class="col-12">
                        <!--<button type="submit" class="btn btn-primary">Guardar</button>-->
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