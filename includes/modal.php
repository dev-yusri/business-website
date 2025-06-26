<?php if (isset($message)): ?>
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
        
                </div>
                <div class="modal-body flex justify-center items-center">
                    <?php foreach ($message as $msg): ?>
                        <h2 class="text-3xl text-extrabold"><?php echo $msg; ?></h2>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer flex align-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($message)): ?>
    <script>
        $(document).ready(function(){
            $('#messageModal').modal('show');
        });
    </script>
<?php endif; ?>