<?php
require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/Model.php';
class Controller
{

    public function inicio()
    {
        $params = array(
            'mensaje' => 'Bienvenido al curso de symfony 1.4',
            'fecha' => date('d-m-Y'),
        );
        require __DIR__ . '/templates/inicio.php';
    }

    public function listar()
    {
        $m = new AlimentosModel();

        $params = array(
            'alimentos' => $m->getAll(),
        );

        require __DIR__ . '/templates/mostrarAlimentos.php';
    }
    public function wiki()
    {
        $m = new AlimentosModel();

        $params = array(
            'alimentos' => $m->getAll(),
        );

        require __DIR__ . '/templates/wikiAlimentos.php';
    }

    public function insertar()
    {
        $params = array(
            'nombre' => '',
            'energia' => '',
            'proteina' => '',
            'hc' => '',
            'fibra' => '',
            'grasa' => '',
        );

        $m = new AlimentosModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // comprobar campos formulario
            if (
                $m->validarDatos(
                    $_POST['nombre'],
                    $_POST['energia'],
                    $_POST['proteina'],
                    $_POST['hc'],
                    $_POST['fibra'],
                    $_POST['grasa']
                )
            ) {
                $m->insert(
                    $_POST['nombre'],
                    $_POST['energia'],
                    $_POST['proteina'],
                    $_POST['hc'],
                    $_POST['fibra'],
                    $_POST['grasa']
                );
                header('Location: index.php?ctl=listar');

            } else {
                $params = array(
                    'nombre' => $_POST['nombre'],
                    'energia' => $_POST['energia'],
                    'proteina' => $_POST['proteina'],
                    'hc' => $_POST['hc'],
                    'fibra' => $_POST['fibra'],
                    'grasa' => $_POST['grasa'],
                );
                $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
            }
        }

        require __DIR__ . '/templates/formInsertar.php';
    }

    public function buscarPorNombre()
    {
        $params = array(
            'nombre' => '',
            'resultado' => array(),
        );

        $m = new AlimentosModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $params['nombre'] = $_POST['nombre'];
            $params['resultado'] = $m->searchByName($_POST['nombre']);
        }

        require __DIR__ . '/templates/buscarPorNombre.php';
    }
    public function buscarPorEnergia()
    {
        $params = array(
            'energia' => '',
            'resultado' => array(),
            'mensaje' => ''
        );

        $m = new AlimentosModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $params['energia'] = $_POST['energia'];
            $params['resultado'] = $m->searchByEnergia($_POST['energia']);
            if (count($params['resultado']) == 0)
                $params['mensaje'] = 'No se han encontrado alimentos con la energía indicada';
        }

        require __DIR__ . '/templates/buscarPorEnergia.php';
    }

    public function buscarAlimentosCombinada()
    {
        $params = array(
            'energia' => '',
            'nombre' => '',
            'resultado' => array(),
            'mensaje' => ''
        );

        $m = new AlimentosModel();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $params['energia'] = $_POST['energia'];
            $params['nombre'] = $_POST['nombre'];
            $params['resultado'] = $m->searchByNameAndEnergy($_POST['energia'], $_POST['nombre']);
            if (count($params['resultado']) == 0)
                $params['mensaje'] = 'No se han encontrado alimentos con la energía y nombre indicados';
        }

        require __DIR__ . '/templates/buscarCombinada.php';
    }


    public function ver()
    {
        if (!isset($_GET['id'])) {
            throw new Exception('Página no encontrada');
        }

        $id = $_GET['id'];

        $m = new AlimentosModel();

        $alimento = $m->getById($id);

        $params = $alimento;

        require __DIR__ . '/templates/verAlimento.php';
    }


}
?>