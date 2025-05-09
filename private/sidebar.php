<div class="col-md-3 col-lg-2 d-md-block sidebar bg-light p-3">
    <div class="text-center mb-4">
        <img src="../assets/img/logo.png" alt="Logo" width="80">
        <h5 class="mt-2">Hotel El Paraíso</h5>
        <p class="text-muted small">Bienvenido, <?php echo $_SESSION['username']; ?></p>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="registrar_cliente.php">
                <i class="fas fa-user-plus me-2"></i> Registrar Cliente
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="habitaciones.php">
                <i class="fas fa-bed me-2"></i> Habitaciones
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="actualizar_cargos.php">
                <i class="fas fa-money-bill-wave me-2"></i> Actualizar Cargos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="salida_cliente.php">
                <i class="fas fa-sign-out-alt me-2"></i> Salida Cliente
            </a>
        </li>
        <li class="nav-item mt-3">
            <a class="nav-link text-danger" href="logout.php">
                <i class="fas fa-power-off me-2"></i> Cerrar Sesión
            </a>
        </li>
    </ul>
</div>