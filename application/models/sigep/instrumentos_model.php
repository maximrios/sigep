<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modelo Provincias
 * 
 * @package base
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Instrumentos_model extends CI_Model {

    function __constructor() {
        
    }
    public function obtener($vcBuscar = '', $anio = 0, $tipo = 0, $tema = 0, $limit = 0, $offset = 9999999) {
        ($anio == 0)? $anio = '':$anio = 'AND anioInstrumentoLegal = '.$anio.'';
        ($tipo == 0)? $tipo = '':$tipo = 'AND idTipoInstrumento = '.$tipo.' ';
        ($tema == 0)? $tema = '':$tema = 'AND idTema = '.$tema.' ';
        $sql = 'SELECT * 
        FROM sigep_view_instrumentoslegales 
        WHERE busqueda LIKE ? '.$anio.' '.$tipo.' '.$tema.'
        ORDER BY fechaInstrumentoLegal DESC 
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * 
                FROM sigep_view_instrumentoslegales
                WHERE idInstrumentoLegal = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function numRegs($vcBuscar, $anio = 0, $tipo = 0, $tema = 0) {
        ($anio == 0)? $anio = '':$anio = 'AND anioInstrumentoLegal = '.$anio.'';
        ($tipo == 0)? $tipo = '':$tipo = 'AND idTipoInstrumento = '.$tipo.' ';
        ($tema == 0)? $tema = '':$tema = 'AND idTema = '.$tema.' ';
        $sql = 'SELECT count(idInstrumentoLegal) AS inCant FROM sigep_view_instrumentoslegales 
        WHERE busqueda LIKE ? '.$anio.' '.$tipo.' '.$tema.';';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerTipos($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $tipo = 1;
        ($tipo == 0)? $tipo = '':$tipo = 'AND idTipoInstrumento = '.$tipo.' ';
        $sql = 'SELECT * 
        FROM sigep_view_instrumentoslegales 
        WHERE busqueda LIKE ? 
        ORDER BY fechaInstrumentoLegal DESC 
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegsTipos($vcBuscar, $tipo=0) {
        ($tipo == 0)? $tipo = '':$tipo = 'AND idTipoInstrumento = '.$tipo.' ';
        $sql = 'SELECT count(idInstrumentoLegal) AS inCant FROM sigep_view_instrumentoslegales 
        WHERE busqueda LIKE ? '.$tipo.';';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function dropdownTipos() {
        $sql = 'SELECT * FROM sigep_instrumentoslegales_tipos';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione tipo de instrumento ...';
        foreach($query as $row) {
            $subgrupos[$row->idInstrumentoLegalTipo] = $row->nombreInstrumentoLegalTipo; 
        }
        return $subgrupos;
    }
    public function obtenerTemas($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * 
                        FROM sigep_temas
                        WHERE textoTema LIKE ? 
                        ORDER BY idTema ASC  
                        limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function obtenerUnoTemas($id) {
        $sql = 'SELECT * 
                FROM sigep_temas
                WHERE idTema = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function numRegsTemas($vcBuscar) {
        $sql = 'SELECT count(idTema) AS inCant 
                        FROM sigep_temas AS pr 
                        WHERE textoTema LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function guardarTemas($aParms) {
        $sql = 'SELECT sigep_sp_instrumentoslegales_temas_guardar(?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }
    public function dropdownTemas() {
        $sql = 'SELECT * FROM sigep_temas';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un tema ...';
        foreach($query as $row) {
            $subgrupos[$row->idTema] = $row->textoTema; 
        }
        return $subgrupos;
    }
    public function dropdownAnios() {
        $sql = 'SELECT DISTINCT(YEAR(fechaInstrumentoLegal)) as anio FROM sigep_instrumentoslegales ORDER BY fechaInstrumentoLegal DESC';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un año ...';
        foreach($query as $row) {
            $subgrupos[$row->anio] = $row->anio; 
        }
        return $subgrupos;
    }
    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_instrumentoslegales_guardar(?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    /*public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function obtenerInstrumentos() {
        $sql = 'SELECT * FROM ttipoinstrumentolegal ORDER BY vcDescripcion;';
        $result = $this->db->query($sql);
        $resultSimple = array();
        foreach ($result->result() as $row) {
            $resultSimple[$row->inIdTipoInstrumentoLegal] = $row->vcDescripcion;
        }
        return $resultSimple;
    }
    public function ObtInstrumentos($simple=true) {
        $this->db->select('inIdTipoInstrumentoLegal, vcDescripcion')->from('ttipoinstrumentolegal')->order_by('vcDescripcion ASC');
        $query = $this->db->get();
        $resultSimple = array();
        if ($simple) {
            foreach ($query->result() as $row) {
                $resultSimple[$row->inIdTipoInstrumentoLegal] = $row->vcDescripcion;
            }
        } else {
            $resultSimple = $query->result();
        }
        return $resultSimple;
    }
    public function obtenerInstrumentosAutocomplete($vcBuscar) {
        $sql = 'SELECT *
            FROM sigep_tipoinstrumentos ti
            INNER JOIN sigep_instrumentoslegales i ON ti.idTipoInstrumento = i.idTipoInstrumento
            WHERE textoTipoInstrumento LIKE ? OR numeroInstrumentoLegal LIKE ?';
        $query = $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', '%' . strtolower((string) $vcBuscar) . '%'));
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $new_row['label']=htmlentities(stripslashes($row['textoTipoInstrumento'].' No '.$row['numeroInstrumentoLegal']));
                $new_row['value']=htmlentities(stripslashes($row['textoTipoInstrumento'].' No '.$row['numeroInstrumentoLegal']));
                $new_row['id']=htmlentities(stripslashes($row['idInstrumentoLegal']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set);
        }
    }


    function obtenerInstrumentos($tipo) {
        $sql = 'SELECT * FROM sigep_view_instrumentoslegales WHERE idTipoInstrumento = '.$tipo;
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerFiltroInstrumentos($tipo, $tema=0, $ano, $clave) {
        $sql = 'SELECT * FROM sigep_view_instrumentoslegales WHERE idTipoInstrumento = '.$tipo.'';
        if ($clave != '') {
            $sql .= ' AND asuntoInstrumentoLegal LIKE "%'.$clave.'%"';
        }
        if($tema > 0) {
            $sql .= ' AND idTema = '.$tema.' ';
        }
        if($ano > 0) {
            $sql .= ' AND anioInstrumentoLegal = '.$ano.'';
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerCalidad($tipo) {
        $sql = 'SELECT * FROM sigep_view_calidad WHERE idTipo = '.$tipo.' ORDER BY ordenCalidad ASC';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerCursos() {
        $sql = 'SELECT * FROM sigep_view_cursos';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerNormas() {
        $sql = 'SELECT * FROM sigep_normas';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerFiltroInstrumentos2() {
        $sql = 'SELECT * FROM sigep_instrumentoslegales WHERE idTipoInstrumento = 1 AND anioInstrumentoLegal = 2009 ORDER BY idInstrumentoLegal ASC';
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    function fixArchivos($id, $numero) {
        
        if($numero > 84) {
            $sql = 'UPDATE sigep_instrumentoslegales SET archivoInstrumentoLegal = "site_media/files/instrumentos/2009/r-'.$numero.'-090001.pdf" WHERE idInstrumentoLegal = '.$id;  
        }
        else {
            $sql = 'UPDATE sigep_instrumentoslegales SET archivoInstrumentoLegal = "site_media/files/instrumentos/2009/R'.$numero.'-09.pdf" WHERE idInstrumentoLegal = '.$id;   
        }
        $query = $this->db->query($sql);
    }
    function anexarArchivo($id, $anio) {
        $sql = 'UPDATE sigep_instrumentoslegales SET archivoInstrumentoLegal = "site_media/files/instrumentos/20'.$anio.'/R-'.$id.'-'.$anio.'.pdf" WHERE idInstrumentoLegal = '.$id;
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }
    function obtenerPedidosCliente($cliente) {
        $sql = 'SELECT * FROM vpedidos WHERE idCliente = ?';
        $query = $this->db->query($sql, $cliente);
        return $query->result_array();
    }
    function obtenerLineas($pedido) {
        $sql = 'SELECT * FROM vlineas WHERE idPedido = ?';
        $query = $this->db->query($sql, $pedido);
        
        return $query->result_array();
    }
    function obtenerPlanCapacitacion() {
        $sql = 'SELECT * FROM sigep_planes_capacitaciones';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerPlanes($tipo) {
        $sql = 'SELECT * FROM sigep_planes WHERE idTipo = '.$tipo.' ORDER BY idPlan desc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerMemorias($tipo) {
        $sql = 'SELECT * FROM sigep_planes WHERE idTipo = '.$tipo.' ORDER BY idPlan desc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function obtenerEvaluaciones($tipo) {
        $sql = 'SELECT * FROM sigep_planes WHERE idTipo = '.$tipo.' ORDER BY idPlan desc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function getTopics() {
        $sql = 'SELECT * FROM sigep_temas ORDER BY textoTema asc';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $subgrupos[$row->idTema] = $row->textoTema; 
        }
        return $subgrupos;  
    }*/


/* End of file pedidos_model.php */
/* Location: ./application/models/admin/pedidos_model.php */

}

// EOF provincias_model.php