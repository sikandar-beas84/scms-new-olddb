<!-- Modal -->
<div class="modal fade" id="user_profile_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="modaleditFormAdd" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="user_profile_modal_title">Modal Title</h5>
                    <button type="button" class="close" onclick="closeModal('user_profile_modal')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="user_profile_modal_body">
                    <!-- Modal body content goes here -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Change</button>
                    <button type="reset" class="btn btn-danger">Clear</button>
                </div>
            </form>
        </div>
    </div>
</div>