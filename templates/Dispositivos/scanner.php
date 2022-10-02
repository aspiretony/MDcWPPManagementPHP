<?php
?>
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Scannear QRCode</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
             <?= $msg ?>
            <br>
            <div id="imagem">
                <?php
                if ($img == null){
                     echo '<img id="image" src="https://media2.giphy.com/media/3oEjI6SIIHBdRxXI40/200.gif">';
                }else{
                    $imgs = $img;
                    echo '<img id="image" src="'.$imgs.'">';
                }

                ?>
              <!--  <img  id="image" src="<?/* $img */?>">-->
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
           MDc ZAPI
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

</section>
