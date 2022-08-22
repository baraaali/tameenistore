<div id="confirmDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="margin-top:50px;">
    <div class="modal-dialog" style="margin-top:50px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Warning ّ!!</h4> </div>
            <div class="modal-body">
                <p>Are you sure, you want to delete ?</p>
            </div>
            <div class="modal-footer">
                <form action="" id="confirm_modal" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-success waves-effect">Submit</button>
                </form>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

