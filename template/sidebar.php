<div class="d-flex">
  <!-- Sidebar -->
  <nav class="bg-light border-end" id="sidebar">
    <div class="sidebar-header p-3">
      <h4>Clínica</h4>
    </div>
    <ul class="list-unstyled">

      <!-- Gestión Administrativa -->
      <li>
        <span href="#adminSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">Gestión Administrativa</span>
        <ul class="collapse list-unstyled" id="adminSubmenu">
          <li><a href="../views/registrar_usuario.php">Registrar Usuario</a></li>
          <li><a href="../views/lista_usuarios.php">Ver todos los usuarios</a></li>
          <li><a href="../views/servicios_medicos.php">Definir y Consultar Servicios Médicos</a></li>
          <li><a href="#">Control de Insumos e Inventario</a></li>
        </ul>
      </li>

      <!-- Gestión de Recursos Humanos -->
      <li>
        <span href="#hrSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">Gestión de Recursos Humanos</span>
        <ul class="collapse list-unstyled" id="hrSubmenu">
          <li><a href="./registrar_medico.php">Registro/Verificación de perfil médico</a></li>
          <li><a href="#">Gestión de turnos y asignación de personal</a></li>
        </ul>
      </li>

      <!-- Gestión de Recepción -->
      <li>
        <span href="#receptionSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">Gestión de Recepción</span>
        <ul class="collapse list-unstyled" id="receptionSubmenu">
          <li><a href="./registrar_paciente.php">Registro de pacientes</a></li>
          <li><a href="#">Registro de pago de consultas</a></li>
          <li><a href="#">Creación/Modificación/Cancelación de Citas</a></li>
        </ul>
      </li>

      <!-- Gestión de Médicos -->
      <li>
        <span href="#doctorSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">Gestión de Médicos</span>
        <ul class="collapse list-unstyled" id="doctorSubmenu">
          <li><a href="#">Lista de pacientes</a></li>
          <li><a href="#">Consultar resultados de análisis médicos</a></li>
          <li><a href="#">Consultar citas del día</a></li>
        </ul>
      </li>

      <!-- Farmacia -->
      <li>
        <span href="#pharmacySubmenu" data-bs-toggle="collapse" class="dropdown-toggle">Farmacia</span>
        <ul class="collapse list-unstyled" id="pharmacySubmenu">
          <li><a href="#">Consultar disponibilidad de medicamento</a></li>
          <li><a href="#">Suministrar medicamentos</a></li>
          <li><a href="#">Solicitar reabastecimiento</a></li>
        </ul>
      </li>

      <!-- Gestión de Pacientes -->
      <li>
        <span href="#patientSubmenu" data-bs-toggle="collapse" class="dropdown-toggle">Gestión de Pacientes</span>
        <ul class="collapse list-unstyled" id="patientSubmenu">
          <li><a href="#">Solicitar consulta médica</a></li>
          <li><a href="#">Acceder a resultados médicos</a></li>
          <li><a href="#">Calendario de citas</a></li>
          <li><a href="#">Actualizar información personal</a></li>
        </ul>
      </li>

    </ul>
  </nav>

  <!-- Main content 
  <div class="p-4" id="content">
    <h2>Contenido Principal</h2>
    <p>Aquidebe ir el contenido dentro del id content en este div el cual esta dentro del div de flex primero del nav</p>
  </div>-->