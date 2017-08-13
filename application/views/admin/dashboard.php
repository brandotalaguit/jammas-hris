<div class="row">
  <!-- Total number of members -->
  <div class="col-lg-3">
    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-6">
            <i class="fa fa-users fa-5x"></i>
          </div>
          <div class="col-xs-6 text-right">
            <p class="announcement-heading"><?php echo count($members) ?></p>
            <p class="announcement-text">Members</p>
          </div>
        </div>
      </div>
      <a href="<?php echo base_url()?>member">
        <div class="panel-footer announcement-bottom">
          <div class="row">
            <div class="col-xs-6">
              View Members
            </div>
            <div class="col-xs-6 text-right">
              <i class="fa fa-arrow-circle-right"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- Total applied of loan for approval-->
  <div class="col-lg-3">
    <div class="panel panel-success">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-6">
            <i class="fa fa-user fa-5x"></i>
          </div>
          <div class="col-xs-6 text-right">
            <p class="announcement-heading"><?php echo count($regular_members) ?></p>
            <p class="announcement-text">Regular Members</p>
          </div>
        </div>
      </div>
      <a href="<?php echo base_url()?>member">
        <div class="panel-footer announcement-bottom">
          <div class="row">
            <div class="col-xs-6">
              View Member
            </div>
            <div class="col-xs-6 text-right">
              <i class="fa fa-arrow-circle-right"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- Total number of members -->
  <div class="col-lg-3">
    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-6">
            <i class="fa fa-user fa-5x"></i>
          </div>
          <div class="col-xs-6 text-right">
            <p class="announcement-heading"><?php echo count($members) - count($regular_members) ?></p>
            <p class="announcement-text">Associate Members</p>
          </div>
        </div>
      </div>
      <a href="<?php echo base_url()?>member">
        <div class="panel-footer announcement-bottom">
          <div class="row">
            <div class="col-xs-6">
              View Members
            </div>
            <div class="col-xs-6 text-right">
              <i class="fa fa-arrow-circle-right"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- Total number of account types -->
  <div class="col-lg-3">
    <div class="panel panel-warning">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-6">
            <i class="fa fa-tasks fa-5x"></i>
          </div>
          <div class="col-xs-6 text-right">
            <p class="announcement-heading"><?php echo count($accounts) ?></p>
            <p class="announcement-text">Account Types</p>
          </div>
        </div>
      </div>
      <a href="<?php echo base_url()?>account">
        <div class="panel-footer announcement-bottom">
          <div class="row">
            <div class="col-xs-9">
              View Account Types
            </div>
            <div class="col-xs-3 text-right">
              <i class="fa fa-arrow-circle-right"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>


<div class="row">

  <div class="col-lg-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-clock-o"></i> Recent Activity</h3>
      </div>
      <div class="panel-body">
        <div class="list-group">
          <?php foreach ($activities as $activity): ?>
          <a href="#" class="list-group-item">
            <span class="badge"><?php echo timespan(human_to_unix($activity->created_at)); ?></span>
            <?php echo $activity->message; ?>
          </a>
          <?php endforeach ?>
        </div>
        <div class="text-right">
          <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </div>


  <div class="col-lg-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money"></i> Recent Transactions</h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped tablesorter">
            <thead>
              <tr>
                <th class="header">Order # <i class="fa fa-sort"></i></th>
                <th class="header">Order Date <i class="fa fa-sort"></i></th>
                <th class="header">Order Time <i class="fa fa-sort"></i></th>
                <th class="header">Amount (USD) <i class="fa fa-sort"></i></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>3326</td>
                <td>10/21/2013</td>
                <td>3:29 PM</td>
                <td>$321.33</td>
              </tr>
              <tr>
                <td>3325</td>
                <td>10/21/2013</td>
                <td>3:20 PM</td>
                <td>$234.34</td>
              </tr>
              <tr>
                <td>3324</td>
                <td>10/21/2013</td>
                <td>3:03 PM</td>
                <td>$724.17</td>
              </tr>
              <tr>
                <td>3323</td>
                <td>10/21/2013</td>
                <td>3:00 PM</td>
                <td>$23.71</td>
              </tr>
              <tr>
                <td>3322</td>
                <td>10/21/2013</td>
                <td>2:49 PM</td>
                <td>$8345.23</td>
              </tr>
              <tr>
                <td>3321</td>
                <td>10/21/2013</td>
                <td>2:23 PM</td>
                <td>$245.12</td>
              </tr>
              <tr>
                <td>3320</td>
                <td>10/21/2013</td>
                <td>2:15 PM</td>
                <td>$5663.54</td>
              </tr>
              <tr>
                <td>3319</td>
                <td>10/21/2013</td>
                <td>2:13 PM</td>
                <td>$943.45</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="text-right">
          <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </div>

</div>