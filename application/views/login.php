<style type="text/css">

.form-signin {
  max-width: 300px;
  padding: 0px 29px 29px;
  margin: 0 auto 20px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  -webkit-border-radius: 5px;
     -moz-border-radius: 5px;
          border-radius: 5px;
  -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
     -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
          box-shadow: 0 1px 2px rgba(0,0,0,.05);
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin input[type="text"],
.form-signin input[type="password"] {
  font-size: 16px;
  height: auto;
  margin-bottom: 15px;
  padding: 7px 9px;
}
.form-title {
  
  border: 1px solid #e5e5e5;
  padding: 5px 10px 15px;
 -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
         border-radius: 5px;
 -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
         box-shadow: 0 1px 2px rgba(0,0,0,.05); 
  margin-bottom: 21px;

  text-align: justify;
}

</style>

<div class="row-fluid">
  <form class="form-signin" method="post" action="<?php echo site_url('/site/page2');?>">
    <div class="btn-danger form-title">

      <h3>
        Please sign in<i class="icon-key icon-2x pull-right"></i>        
      </h3>
    </div>
    <p class="muted">
      <strong>Note: </strong>Username and Password are case-sensitive, make sure you type them accordingly.
    </p>


    <div class="input-prepend">
      <span class="add-on" style="height:26px; width:35px"><i class="icon-user icon-2x"></i></span>
      <input type="text" class="input-block-level" placeholder="User Name" autofocus>
    </div>

    <div class="input-prepend">
      <span class="add-on" style="height:26px; width:35px"><i class="icon-lock icon-2x"></i></span>
      <input type="password" class="input-block-level" placeholder="Password">
    </div>

    <button class="btn btn-large btn-block btn-success" type="submit">Log in <i class="icon-double-angle-right"></i></button>

  </form>
</div>