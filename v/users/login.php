<section>
    <div class="col-12s"><h2 class="center">Books & Dungeons</h2></div>
</section>
<section>
    <div class="col-12s col-2m col-hidden-s"></div>
    <div class="col-12s col-8m card">
        <div class="col-12s paddingless">
            <section class="tab-container" tabgroup="tab-group-1">
                <div class="col-4s tab-item tab-selected" tabid="login">Login</div>
                <div class="col-4s tab-item" tabid="register">Register</div>
                <div class="col-4s tab-item" tabid="recover">Recover</div>
            </section>
        </div>
        <section id="login" class="col-12s tab-content tab-group-1">
            <form onsubmit="return false;">
                <section>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                    <div class="col-12s col-8l">
                        <i class="fas fa-at input"></i>
                        <input id="login_email" type="email" class="full icon" error="should be a valid email" content="Email" autocomplete="email">
                        <label class="icon" for="login_email">Email</label>
                    </div>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                </section>
                <section>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                    <div class="col-12s col-8l">
                        <i class="fas fa-fingerprint input"></i>
                        <input id="login_password" type="password" class="full icon" error="should not be empty" content="Password" autocomplete="current-password">
                        <label class="icon" for="login_password">Password</label>
                    </div>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                </section>
                <section>
                    <div class="col-12s paddingless">
                        <section>
                            <div class="col-12s col-8m col-hidden-s"></div>
                            <div class="col-12s col-4m paddingless">
                                <button id="login_button" class="full">Login</button>
                            </div>
                        </section>
                    </div>
                </section>
            </form>
        </section>
        <div id="register" class="col-12s tab-content tab-group-1" style="display: none;">
            <form onsubmit="return false;">
                <section>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                    <div class="col-12s col-8l">
                        <i class="fas fa-at input"></i>
                        <input id="reg_email" type="email" class="full icon" error="should be a valid email" content="Email" autocomplete="email">
                        <label class="icon" for="reg_email">Email</label>
                    </div>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                </section>
                <section>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                    <div class="col-12s col-8l">
                        <i class="far fa-user-circle input"></i>
                        <input id="reg_username" type="text" class="full icon" error="should not be empty" content="Username" autocomplete="username">
                        <label class="icon" for="reg_username">Username</label>
                    </div>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                </section>
                <section>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                    <div class="col-12s col-8l">
                        <i class="fas fa-fingerprint input"></i>
                        <input id="reg_password" type="password" class="full icon" error="should not be empty" content="Password" autocomplete="new-password">
                        <label class="icon" for="reg_password">Password</label>
                    </div>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                </section>
                <section>
                    <div class="col-12s paddingless">
                        <section>
                            <div class="col-12s col-8m col-hidden-s"></div>
                            <div class="col-12s col-4m paddingless">
                                <button id="reg_button" class="full">Register</button>
                            </div>
                        </section>
                    </div>
                </section>
            </form>
        </div>
        <div id="recover" class="col-12s tab-content tab-group-1" style="display: none;">
            <form onsubmit="return false;">
                <section>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                    <div class="col-12s col-8l">
                        <i class="fas fa-at input"></i>
                        <input id="rec_email" type="email" class="full icon" error="should be a valid email" content="Email" autocomplete="username">
                        <label class="icon" for="rec_email">Email</label>
                    </div>
                    <div class="col-12s col-2l col-hidden-s col-hidden-m"></div>
                </section>
                <section>
                    <div class="col-12s paddingless">
                        <section>
                            <div class="col-12s col-8m col-hidden-s"></div>
                            <div class="col-12s col-4m paddingless">
                                <button id="rec_button" class="full">Recover</button>
                            </div>
                        </section>
                    </div>
                </section>
            </form>
        </div>
    </div>
    <div class="col-12s col-2m col-hidden-s"></div>
</section>
<script>
    $(() => {
        $(document).on('click', '#login_button', () => {
            let valid = true;
            if (isEmpty('login_email') || isNotEmail('login_email')) {
                inputError('login_email');
                valid = valid && false;
            }
            if (isEmpty('login_password')) {
                inputError('login_password');
                valid = valid && false;
            }
            if (valid) {
                let data = {request: "login", email: $('#login_email').val(), password: $('#login_password').val()};
                service('/ms/users.php', data)
                    .then((data) => {
                        snackbar('result', data.message);
                        if (data.success) {
                            postRedirect('users', 'dashboard');
                        } else {
                            empty('login_password');
                            inputError('login_email');
                            inputError('login_password');
                        }
                    })
                    .catch((error) => {
                        // TODO: Mail Admin page and error
                        snackbar('result', error);
                    });
            }
        });
        $(document).on('click', '#reg_button', () => {
            let valid = true;
            if (isEmpty('reg_email') || isNotEmail('reg_email')) {
                inputError('reg_email');
                valid = valid && false;
            }
            if (isEmpty('reg_username')) {
                inputError('reg_username');
                valid = valid && false;
            }
            if (isEmpty('reg_password')) {
                inputError('reg_password');
                valid = valid && false;
            }
            if (valid) {
                let data = {request: "register", email: $('#reg_email').val(), username: $('#reg_username').val(), password: $('#reg_password').val()};
                service('/ms/users.php', data)
                    .then((data) => {
                        snackbar('result', data.message);
                        if (data.success) {
                            empty('reg_email');
                            empty('reg_username');
                            empty('reg_password');
                        } else {
                            $('#reg_password').val('');
                            inputError('reg_email');
                            inputError('reg_username');
                            inputError('reg_password');
                        }
                    })
                    .catch((error) => {
                        // TODO: Mail Admin page and error
                        snackbar('result', error);
                    });
            }
        });
        $(document).on('click', '#rec_button', () => {
            let valid = true;
            if (isEmpty('rec_email') || isNotEmail('rec_email')) {
                inputError('rec_email');
                valid = valid && false;
            }
            if (valid) {
                let data = {request: "recover", email: $('#rec_email').val()};
                service('/ms/users.php', data)
                    .then((data) => {
                        snackbar('result', data.message);
                        if (data.success) {
                            // redirect
                        } else {
                            inputError('rec_email');
                        }
                    })
                    .catch((error) => {
                        // TODO: Mail Admin page and error
                        snackbar('result', error);
                    });
            }
        });
    });
</script>
<?php
//$users = User::listAll();
//echo'<pre>';print_r($users);echo'</pre>';