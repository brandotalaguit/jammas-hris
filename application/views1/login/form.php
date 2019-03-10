<div class="form-box" id="login-box">
    <div class="header">
        <h2>
        User Login | <small style="color:#ddd">Please login using your credential</small>
        </h2>
    </div>




    <?php echo form_open(NULL, ['role' => 'form']); ?>

        <div class="body bg-gray">
            <p class="muted">
                <strong>Note: </strong>Username and Password are case-sensitive, make sure you type them accordingly.
            </p>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="callout callout-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>      

            <?php endif ?>


            <div class="form-group">
                <input type="text" name="Username" class="form-control" placeholder="User ID" autofocus/>
            </div>
            <div class="form-group">
                <input type="password" name="Password" class="form-control" placeholder="Password"/>
            </div>          

        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
        </div>
    </form>

    <div class="margin text-center">
        <span>Sign in using social networks</span>
        <br/>
        <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
        <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
        <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

    </div>
</div>