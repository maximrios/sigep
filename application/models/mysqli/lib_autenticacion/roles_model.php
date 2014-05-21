<?php

/**
 * Roles Model class
 *
 * @package base
 * @author  Marcelo Gutierrez
 * @copyright 2011-12-01
 * @version MySql 1.0.0
 * 
 * Adaptado a MySql por Nacho Fassini
 */
class Roles_model extends CI_Model {

    function __constructor() {
        
    }

    public function obtener($vcBuscar, $limit = 0, $offset = 9999999) {
        /**
         * los campos de b�squeda NO deben ser nulables (que permitan ser nulos) sino la consulta podria no devolver resultados
         * siempre q se modifique obtener() hay q modificar numRegs()
         * se recomienda que el cuerpo desde el "from" hasta el "where" inclusive sean iguales en obtener() y numRegs()
         * concatenar los campos que filtran b�squeda siempre con un espacio para que no se deforme la b�squeda
         * no hacer "select * from.." sino por el contrario poner los campos que se quiere devolver en la consulta
         * nunca pasar datos como parte del string del $sql, siemrpe utilizar el array de par�metros
         * */
        $sql = 'SELECT inIdRol, vcRolNombre, vcRolCod, inRolRango
                        FROM tsegroles
                        WHERE lower(CONCAT_WS(",",vcRolNombre, vcRolCod)) LIKE ?
                        ORDER BY vcRolNombre ASC
                        LIMIT ? OFFSET ?;';
        return $this->db->query($sql, array((string) '%' . strtolower($vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }

    public function numRegs($vcBuscar) {
        /**
         * no hacer "count(*)" sino por el contrario contar la clave primaria de la tabla a contabilizar
         * el "from" es exactamente igual al "from" de la funcion obtener()
         * el "where" es igual al "where" de la funcion obtener()
         * nunca pasar datos como parte del string del $sql, siemrpe utilizar el array de par�metros
         * */
        $sql = 'SELECT count(inIdRol) AS inCant
                        FROM tsegroles
                        WHERE lower(CONCAT_WS("",vcRolNombre, vcRolCod)) like ?;';
        $result = $this->db->query($sql, array((string) '%' . strtolower($vcBuscar) . '%'))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        /**
         * no hacer "select * from.." sino por el contrario poner los campos que se quiere devolver en la consulta
         * nunca pasar datos como parte del string del $sql, siemrpe utilizar el array de par�metros
         * no olvidar nunca el "LIMIT 1", hace q siempre devuelva 1 solo valor
         * */
        $sql = 'SELECT inIdRol, vcRolNombre, vcRolCod, inRolRango
                        FROM tsegroles
                        WHERE inIdRol = ?
                        LIMIT  1;';
        $result = $this->db->query($sql, array((double) $id))->result_array();
        return array_shift($result);
    }

    public function guardar($aParms) {
        $sql = 'SELECT ufn30tsegrolesguardar(? ,? ,? ,? ) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsegrolesborrar(? ) as result;';
        $result = $this->db->query($sql, array((double) $id))->result_array();
        return $result[0]['result'];
    }

    public function obtenerTodosDdl($boAddEmpty = false) {
        $rsRegs = $this->obtener('');
        $aResult = array();
        if ($boAddEmpty == TRUE) {
            $aResult[''] = 'Seleccionar...';
        }
        foreach ($rsRegs as $Reg) {
            $aResult[$Reg['inIdRol']] = $Reg['vcRolNombre'];
        }
        return $aResult;
    }

}

// EOF roles_model.php