<?php $v->layout("_theme.php") ?>

<div class="container">
    <div class="row p-5">
        <div class="col-12">
            <h3>FileTransfer</h3>
            <p>Lista de arquivos enviados</p>
            <div class="d-flex float-right">
                <a href="" data-toggle="modal" data-target="#exampleModalCenter">Enviar novo arquivo</a>
            </div>
            <hr>
            <?php if ($files): ?>
                <div class="overflow-auto">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Arquivo</th>
                            <th scope="col">Tamanho</th>
                            <th scope="col">Envio</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $aux = 1;
                        foreach ($files as $file): ?>
                            <tr>
                                <th scope="row"><?= $aux; ?></th>
                                <td><?= $file->user_name; ?></td>
                                <td><?= $file->file_name; ?></td>
                                <td><?= number_format($file->size / (1 << 20), 2); ?> Mb</td>
                                <td><?= date("d/m/Y - H:m:s", strtotime($file->created_at)); ?></td>
                                <td>
                                    <button class="btn btn-primary" type="button"
                                            onclick="downloadFile(<?= $file->id; ?>)">
                                        <span class="icon-download"></span>
                                    </button>
                                    <button class="btn btn-secondary ml-sm-3" type="button"
                                            onclick="openFile('<?= $file->file_name; ?>')">
                                        <span class="icon-eye"></span>
                                    </button>
                                    <button class="btn btn-danger ml-sm-3" type="button"
                                            onclick="deleteFile(<?= $file->id; ?>)">
                                        <span class="icon-delete"></span>
                                    </button>
                                </td>
                            </tr>
                            <?php $aux++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center pt-5 mt-5">
                    <img class="w-50" src="<?= url("themes/assets/img/empty.svg") ?>">
                    <h4>Não encontramos nenhum arquivo.</h4>
                    <p>Envie um ou volte mais tarde.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Enviar novo anexo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="myForm" method="post" action="<?= $router->route("web.uploadFile"); ?>">
                <fieldset class="modal-body">
                    <div class="form-group">
                        <label>Seu nome:</label>
                        <input id="inputName" type="text" class="form-control" name="name"
                               placeholder="Insira seu nome:" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Arquivo:</label>
                        <input type="file" class="form-control" name="myFile" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </fieldset>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
    $("form").on("submit", function (e) {
        e.preventDefault();
        $("#loader-div").show();

        const _thisForm = $(this);
        const data = new FormData(this);

        $.ajax({
            type: _thisForm.attr("method"),
            url: _thisForm.attr("action"),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
        }).done(function (returnData) {
            if (returnData == true) {
                swal({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Seu arquivo foi enviado com sucesso!",
                }).then((value) => {
                    window.location.href = "<?= url(); ?>";
                });
            } else {
                swal({
                    icon: "warning",
                    title: "Ops...!",
                    text: "Não foi possível enviar seu arquivo.",
                });
            }
        }).fail(function () {
            swal({
                icon: "error",
                title: "Erro!",
                text: "Erro ao processar requisição",
            });
        }).always(function () {
            $("#loader-div").hide();
        });
    });

    function downloadFile(fileId) {
        window.location.href = "<?= url("downloadFile") ?>/" + fileId;
    }

    function deleteFile(fileId) {
        window.location.href = "<?= url("deleteFile") ?>/" + fileId;
    }
    
    function openFile(fileName) {
        window.open("<?= url("themes/assets/uploads/") ?>" + fileName, "_blank");
    }
</script>
<?php $v->end(); ?>
