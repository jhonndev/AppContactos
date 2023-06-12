<?=$head?>
<?=$navbar?>

<div class="container mt-2">
    <h2>Contactos</h2>

    <div class="mt-4">
        <a class="btn btn-success" href="<?= site_url('crear') ?>">Crear Contacto</a>
    </div>

    <div class="mt-2">
        <?php if (session()->has('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if (session()->has('errorEliminar')) : ?>
        <div class="alert alert-danger  alert-dismissible fade show" role="alert">
            <?= session('errorEliminar') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Correo</th>
                <th scope="col">Foto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contactos as $contacto) : ?>
            <tr>
                <td><?= $contacto['nombre'] ?></td>
                <td><?= $contacto['apellidos'] ?></td>
                <td><?= $contacto['telefono'] ?></td>
                <td><?= $contacto['correo'] ?></td>
                <td>
                    <img class="img-thumbnail"
                        src="<?= $contacto['foto'] ? $urlPath.''.$contacto['foto'] : $urlImageDefault  ?>" width="100"
                        alt="...">
                </td>
                <td>
                    <a class="btn btn-warning" href="<?= site_url('editar/'.$contacto['id']) ?>"><i
                            class="bi bi-pencil"></i> Editar</a>
                    <a class="btn btn-danger" href="<?= site_url('eliminar/'.$contacto['id']) ?>"><i
                            class="bi bi-trash"></i> Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?=$footer?>