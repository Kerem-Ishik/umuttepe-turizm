<style>
    .navbar-brand {
        user-select: none;
        cursor: pointer;
    }

    #e_posta {
        user-select: none;
    }
</style>

<header>
    <nav class="navbar navbar-expand-lg w-100 px-2 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('/') ?>">Umuttepe Turizm</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleContent" aria-controls="navbarToggleContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggleContent">
                <div class="d-flex flex-row justify-content-center justify-content-lg-end w-100">
                    <div class="d-flex flex-column flex-lg-row gap-2 align-items-center">
                        <span id="e_posta" class="navbar-text"><?= session()->get('userInfo')['e_posta'] ?></span>
                        <a role="button" href="<?= base_url('logout') ?>" class="btn btn-danger">Çıkış yap</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>