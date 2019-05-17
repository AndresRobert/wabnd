<?php $user = new User(['id' => $_SESSION['bnd_user_authenticated']]); ?>
<section>
    <div class="col-12s"><h2 class="left">Dashboard</h2></div>
    <div class="col-12s card">
        <h4>Profile</h4>
        <wrapper id="edit-info">
            <section class="padding">
                <div class="col-12s col-4m paddingless">
                    <section>
                        <div class="col-12s paddingless">
                            <img id="avatar_profile_img" class="avatar_profile" style="max-height: 14rem;" old="<?php echo Helper::imgProfile(['filename' => $user->col['avatar']]) ?>" src="<?php echo Helper::imgProfile(['filename' => $user->col['avatar']]) ?>">

                            <input id="profile_avatar" style="position: fixed; visibility: hidden;" type="file" accept="image/jpg, image/jpeg, image/png" onchange="readImg(this);">
                            <script>
                                function readImg(input) {
                                    if (input.files && input.files[0]) {
                                        let reader = new FileReader();
                                        reader.onload = function (e) {$('#avatar_profile_img').attr('src', e.target.result);};
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                            </script>
                        </div>
                    </section>
                </div>
                <div class="col-12s col-8m paddingless">
                    <section>
                        <div class="col-12s padding">
                            <input id="profile_username" class="full edit-input" type="text" old="<?php echo $user->col['username']; ?>" value="<?php echo $user->col['username']; ?>" readonly>
                            <label class="icon" for="profile_username">User</label>
                        </div>
                        <div class="col-12s padding">
                            <input id="profile_email" class="full edit-input" type="email" old="<?php echo $user->col['email']; ?>" value="<?php echo $user->col['email']; ?>" readonly>
                            <label class="icon" for="profile_email">Email</label>
                        </div>
                        <div class="col-12s padding">
                            <input id="profile_name" class="full edit-input" type="text" old="<?php echo $user->col['name']; ?>" value="<?php echo $user->col['name']; ?>" readonly>
                            <label class="icon" for="profile_name">Name</label>
                        </div>
                        <div class="col-12s padding">
                            <input id="profile_age" class="full edit-input" type="number" old="<?php echo $user->col['age']; ?>" value="<?php echo $user->col['age']; ?>" readonly>
                            <label class="icon" for="profile_age">Age</label>
                        </div>
                    </section>
                </div>
            </section>
            <section>
                <div class="col-12s">
                    <button id="editNow" class="to-right no-edit full-on-small">Edit</button>
                    <button id="editCancel" class="to-right edit full-on-small" style="display: none;">Cancel</button>
                    <button id="editSave" class="to-right edit full-on-small" style="display: none;">Save</button>
                </div>
                <script>
                    $(() => {
                        $(document).on('click', '#editNow', () => {
                            $('.no-edit').toggle();
                            $('.edit').toggle();
                            $('.edit-input').prop('readonly', false);
                        });
                        $(document).on('click', '#editCancel', () => {
                            $('.no-edit').toggle();
                            $('.edit').toggle();
                            $('.edit-input')
                                .prop('readonly', true)
                                .each((e, t) => {
                                    $(t).val($(t).attr('old'));
                                });
                        });
                        $(document).on('click', '#editSave', () => {
                            // TODO: Save user
                        });
                    });
                </script>
            </section>
        </wrapper>
    </div>
</section>