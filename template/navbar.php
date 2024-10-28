<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">Clínica</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">

        <!-- Gestión Administrativa -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión Administrativa
          </a>
          <ul class="dropdown-menu" aria-labelledby="adminDropdown">
            <li><a class="dropdown-item" href="../views/registrar_usuario.php">Registrar Usuario</a></li>
            <li><a class="dropdown-item" href="../views/lista_usuarios.php">Ver todos los usuarios</a></li>
            <li><a class="dropdown-item" href="../views/servicios_medicos.php">Definir y Consultar Servicios Médicos</a></li>
            <li><a class="dropdown-item" href="#">Control de Insumos e Inventario</a></li>
          </ul>
        </li>

        <!-- Gestión de Recursos Humanos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="hrDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión de Recursos Humanos
          </a>
          <ul class="dropdown-menu" aria-labelledby="hrDropdown">
            <li><a class="dropdown-item" href="./registrar_medico.php">Registro/Verificación de perfil médico</a></li>
            <li><a class="dropdown-item" href="#">Gestión de turnos y asignación de personal</a></li>
          </ul>
        </li>

        <!-- Gestión de Recepción -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="receptionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión de Recepción
          </a>
          <ul class="dropdown-menu" aria-labelledby="receptionDropdown">
            <li><a class="dropdown-item" href="./registrar_paciente.php">Registro de pacientes</a></li>
            <li><a class="dropdown-item" href="#">Registro de pago de consultas</a></li>
            <li><a class="dropdown-item" href="#">Creación/Modificación/Cancelación de Citas</a></li>
          </ul>
        </li>

        <!-- Gestión de Médicos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="doctorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión de Médicos
          </a>
          <ul class="dropdown-menu" aria-labelledby="doctorDropdown">
            <li><a class="dropdown-item" href="#">Lista de pacientes</a></li>
            <li><a class="dropdown-item" href="#">Consultar resultados de análisis médicos</a></li>
            <li><a class="dropdown-item" href="#">Consultar citas del día</a></li>
          </ul>
        </li>

        <!-- Farmacia -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pharmacyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Farmacia
          </a>
          <ul class="dropdown-menu" aria-labelledby="pharmacyDropdown">
            <li><a class="dropdown-item" href="#">Consultar disponibilidad de medicamento</a></li>
            <li><a class="dropdown-item" href="#">Suministrar medicamentos</a></li>
            <li><a class="dropdown-item" href="#">Solicitar reabastecimiento</a></li>
          </ul>
        </li>

        <!-- Gestión de Pacientes -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="patientDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gestión de Pacientes
          </a>
          <ul class="dropdown-menu" aria-labelledby="patientDropdown">
            <li><a class="dropdown-item" href="#">Solicitar consulta médica</a></li>
            <li><a class="dropdown-item" href="#">Acceder a resultados médicos</a></li>
            <li><a class="dropdown-item" href="#">Calendario de citas</a></li>
            <li><a class="dropdown-item" href="#">Actualizar información personal</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
