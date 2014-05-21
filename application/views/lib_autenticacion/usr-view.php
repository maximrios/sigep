<div class="forms" style="margin: 0; float:left;">
  <div class="inputUsuario inputPegadosIzq inputPegadosTopIzq">
  	<span title="<?= $vcUsuarioActual; ?>"><?= ellipsize($vcUsuarioActual,20); ?></span>
  </div>
  <ul class="dropdown">
    <li><a href="javascript:void(0)" class="button editar inputPegadosDer inputPegadosTopDer">Opciones de Usuario</a>
      <div class="sub">
        <ul>
          <li><a href="<?= base_url().$this->lib_autenticacion->opciones['edit_profile_uri'] ?>" class="button editar">Cambiar mis datos</a></li>
          <li><a href="<?= base_url().$this->lib_autenticacion->opciones['logout_uri'] ?>" class="button eliminar">Cerrar mi sesi&oacute;n</a></li>
        </ul>
      </div>
    </li>
  </ul>
  <div class="clearfloat">&nbsp;</div>
</div>
