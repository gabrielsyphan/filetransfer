<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Email;
use Source\Models\Files;
use Stonks\Router\Router;

class Web
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Engine
     */
    private $view;
    private $service;

    /**
     * Web constructor.
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->view = Engine::create(THEMES, 'php');
        $this->view->addData([
            'router' => $router,
        ]);

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
    }

    /**
     * @return void
     */
    public function home(): void
    {
        $files = (new Files())->find()->fetch(true);
        echo $this->view->render("home", [
            "title" => "Filetransfer",
            "files" => $files
        ]);
    }

    public function uploadFile($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $response = false;

        if($_FILES) {
            foreach ($_FILES as $key => $file) {
                $target_file = basename($file['name']);

                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                $folder = THEMES . '/assets/uploads';
                if (!file_exists($folder) || !is_dir($folder)) {
                    mkdir($folder, 0755);
                }
                $fileName = $file['name'];

                $dir = $folder . '/' . $fileName;

                move_uploaded_file($file['tmp_name'], $dir);

                $file = new Files();
                $file->user_name = $data['name'];
                $file->size = filesize($dir);
                $file->file_name = $fileName;
                $file->path = $dir;
                $file->save();

                if(!$file->fail()) {
                    $response = true;
                }

                $email = new Email();
                $email->add(
                    "Novo arquivo cadastrado",
                    "
                            <h4>Um novo arquivo foi enviado para o Filetransfer</h4>
                            <p>Usuário: ". $file->user_name ."</p>
                            <p>Nome do arquivo: ". $file->file_name ."</p>
                            <p>Tamanho: ". number_format($file->size / (1 << 20), 2) ."</p>
                            <p>Data: ". $file->user_name ."</p>
                            ",
                    NOME,
                    \EMAIL
                )->send();
            }
        }

        echo $response;
    }

    public function downloadFile($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $file = (new Files())->findById($data['fileId']);
        if($file) {
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma: no-cache");
            header("Content-type: application/x-msexcel");
            header("Content-Description: PHP Generated Data");

            $fileToDownload = file_get_contents(
                THEMES . "/assets/uploads/{$file->file_name}"
            );

            header("Content-Disposition: attachment; filename=\"{$file->file_name}\"");
            echo($fileToDownload);
        } else {
            $this->router->redirect("web.home");
        }
    }

    public function deleteFile($data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $file = (new Files())->findById($data['fileId']);
        if($file) {
            unlink($file->path);
            $file->destroy();
        }

        $this->router->redirect("web.home");
    }

    /**
     * @param array $data
     * @return void
     */
    public function error(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        echo $this->view->render('error', [
            'title' => "Erro {$data['errcode']} | " . SITE,
            'error' => $data['errcode'],
        ]);
    }
}
