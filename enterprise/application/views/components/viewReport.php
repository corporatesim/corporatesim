<!--   <link href="http://ttc.microwarecomp.com/common/backend/css/app.min.1.css" rel="stylesheet">
  <link href="http://ttc.microwarecomp.com/common/backend/css/app.min.2.css" rel="stylesheet"> -->
  <div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
      <?php $this->load->view('components/trErMsg');?>
      <div class="min-height-200px">
        <div class="page-header">
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <!-- <div class="title">
                <h1><a href="javascript:void(0);" data-toggle="tooltip" title="Reports"><i class="fa fa-file text-blue"> 
                </i></a> Online Reports</h1>
              </div> -->
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('OnlineReport');?>">Online Report</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Game:- <?php echo $gameName->Game_Name?></li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="title">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                 <!--  <div class="clearfix mb-20">
                    <h5 class="text-blue">See the users report acoordingly</h5>
                  </div> -->

                  <!-- add users details here -->
                  <div class="row col-md-12 col-lg-12 col-sm-12 form-group mb-20" id="showUserReport">
                    <table id="data_table_id" class="table table-condensed table-striped table-hover table-bordered table-responsive">
                      <thead id="table_body">
                        <tr>
                          <th data-column-id="ID" data-identifier="true" data-header-align="center">ID</th>
                          <?php foreach ($tableHeader as $tableHeaderRow) { ?>
                            <th data-column-id="<?php echo $tableHeaderRow; ?>" data-identifier="true" data-header-align="center"><?php echo $tableHeaderRow; ?></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $j=1; foreach ($userData as $userDataRow) { ?>
                          <tr>
                            <td><?php echo $j; ?></td>
                            <!-- <?php // print_r($userDataRow); echo "<br><br>"; ?> -->
                            <?php for($i=0; $i<count($tableHeader); $i++) { ?>
                              <td>
                                <?php echo (array_key_exists($tableHeader[$i], $userDataRow))?$userDataRow[$tableHeader[$i]]:NULL; ?>
                              </td>
                            <?php } ?>
                          </tr>
                          <?php $j++; } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- end of adding users -->
                </div>
              </div>

              <script>
                $(document).ready(function(){
                  $("#data_table_id").bootgrid({
                    caseSensitive: false,
                    selection    : true,
                    // multiSelect  : true,
                    rowSelect    : true,
                    keepSelect   : true,
                    css: {
                      icon       : 'fa',
                      iconColumns: 'fa fa-server',
                      iconDown   : 'fa fa-angle-down',
                      iconRefresh: 'fa fa-refresh',
                      iconUp     : 'fa fa-angle-up',
                      // search     :'fa fa-search'
                    },
                  }).on("loaded.rs.jquery.bootgrid", function () {

                    if ($('[data-toggle="tooltip"]')[0]) {
                      $('[data-toggle="tooltip"]').tooltip();
                    }

                    // $('[data-toggle=confirmation]').confirmation({
                    //   rootSelector: '[data-toggle=confirmation]',
                    // });
                  });
                });
              </script>           
              <style>
               .pagination {
                display: inline-block;
                padding-left: 0;
                margin: 18px 0;
                border-radius: 2px;
              }

              .pagination > li {
                display: inline;
              }

              .pagination > li > a,
              .pagination > li > span {
                position: relative;
                float: left;
                padding: 6px 12px;
                line-height: 1.42857143;
                text-decoration: none;
                color: #7e7e7e;
                background-color: #e2e2e2;
                border: 1px solid #ffffff;
                margin-left: -1px;
              }

              .pagination > li:first-child > a,
              .pagination > li:first-child > span {
                margin-left: 0;
                border-bottom-left-radius: 2px;
                border-top-left-radius: 2px;
              }

              .pagination > li:last-child > a,
              .pagination > li:last-child > span {
                border-bottom-right-radius: 2px;
                border-top-right-radius: 2px;
              }

              .pagination > li > a:hover,
              .pagination > li > span:hover,
              .pagination > li > a:focus,
              .pagination > li > span:focus {
                z-index: 2;
                color: #333333;
                background-color: #d7d7d7;
                border-color: #ffffff;
              }

              .pagination > .active > a,
              .pagination > .active > span,
              .pagination > .active > a:hover,
              .pagination > .active > span:hover,
              .pagination > .active > a:focus,
              .pagination > .active > span:focus {
                z-index: 3;
                color: #ffffff;
                background-color: #00bcd4;
                border-color: #ffffff;
                cursor: default;
              }

              .pagination > .disabled > span,
              .pagination > .disabled > span:hover,
              .pagination > .disabled > span:focus,
              .pagination > .disabled > a,
              .pagination > .disabled > a:hover,
              .pagination > .disabled > a:focus {
                color: #777777;
                background-color: #e2e2e2;
                border-color: #ffffff;
                cursor: not-allowed;
              }

              .pagination-lg > li > a,
              .pagination-lg > li > span {
                padding: 10px 16px;
                font-size: 17px;
                line-height: 1.3333333;
              }

              .pagination-lg > li:first-child > a,
              .pagination-lg > li:first-child > span {
                border-bottom-left-radius: 2px;
                border-top-left-radius: 2px;
              }

              .pagination-lg > li:last-child > a,
              .pagination-lg > li:last-child > span {
                border-bottom-right-radius: 2px;
                border-top-right-radius: 2px;
              }

              .pagination-sm > li > a,
              .pagination-sm > li > span {
                padding: 5px 10px;
                font-size: 12px;
                line-height: 1.5;
              }

              .pagination-sm > li:first-child > a,
              .pagination-sm > li:first-child > span {
                border-bottom-left-radius: 2px;
                border-top-left-radius: 2px;
              }

              .pagination-sm > li:last-child > a,
              .pagination-sm > li:last-child > span {
                border-bottom-right-radius: 2px;
                border-top-right-radius: 2px;
              }

              .pagination {
                border-radius: 0;
              }

              .pagination > li {
                margin: 0 2px;
                display: inline-block;
                vertical-align: top;
              }

              .pagination > li > a,
              .pagination > li > span {
                border-radius: 50% !important;
                padding: 0;
                width: 40px;
                height: 40px;
                line-height: 38px;
                text-align: center;
                font-size: 14px;
                z-index: 1;
                position: relative;
                cursor: pointer;
              }

              .pagination > li > a > .zmdi,
              .pagination > li > span > .zmdi {
                font-size: 22px;
                line-height: 39px;
              }

              .pagination > li.disabled {
                opacity: 0.5;
                filter: alpha(opacity=50);
              }

              .lv-pagination {
                width: 100%;
                text-align: center;
                padding: 40px 0;
                border-top: 1px solid #F0F0F0;
                margin-top: 0;
                margin-bottom: 0;
              }
              tr.active{
                background-color: #00bcd4 !important;
              }
              .bootgrid-table td.select-cell, .bootgrid-table th.select-cell{
                display: none;
              }
              .bootgrid-footer .search, .bootgrid-header .search{
                margin: 0 20px -25px 0;
              }
            </style>