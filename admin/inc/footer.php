	<footer class="main-footer">
	    <!-- To the right -->
	    <div class="float-right d-none d-sm-inline">
	      Anything you want
	    </div>
	    <!-- Default to the left -->
	    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  	</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- page script -->
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
<script>
  $(function () {
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
  });
</script>
<!-- order confirmation -->
<script type="text/javascript">
  $(document).ready(function(){
    $(function(){
        $(document).on('click', '.confirm-ord', confirmOrder);
    })

    function confirmOrder(e) {
      e.preventDefault();
      var order_id   =  $(this).data('id');
      $.ajax({
        url: "../search.php?type=confirm",
        type: "GET",
        data:{order_id:order_id},
        success:function(data){
          if (data == 1) {
            Swal.fire({
              icon: 'success',
              text: 'X??c nh???n ????n h??ng th??nh c??ng',
              showConfirmButton: false,
              timer: 1200
            }).then((result) => {
              if (result.isConfirmed == false) {
                  window.location = "order.php";
              }
            });
          } else{
            Swal.fire({
              icon: 'error',
              text: 'X??c nh???n ????n h??ng th???t b???i',
              showConfirmButton: false,
              timer: 1200
            });
          }
        }
      });
    }
  });
</script>
<!-- cancel order -->
<script type="text/javascript">
  $(document).ready(function(){
    $(function(){
      $(document).on('click', '.cancel-ord', cancelOrder);
    })

    function cancelOrder(e){
      e.preventDefault();
      var order_id   =  $(this).data('id');
      $.ajax({
        url: "../search.php?type=cancel",
        type: "GET",
        data:{order_id:order_id},
        success:function(data){
          if (data == 1) {
            Swal.fire({
              icon: 'success',
              text: 'H???y ????n h??ng th??nh c??ng',
              showConfirmButton: false,
              timer: 1200
            }).then((result) => {
              if (result.isConfirmed == false) {
                  window.location = "order.php";
              }
            });
          } else{
            Swal.fire({
              icon: 'error',
              text: 'H???y ????n h??ng th???t b???i',
              showConfirmButton: false,
              timer: 1200
            });
          }
        }
      });
    }
  });
</script>

<!-- checkout order -->
<script type="text/javascript">
  $(document).ready(function(){
      $(function(){
      $(document).on('click', '.checkout-ord', checkoutOrder);
    })

    function checkoutOrder(e){
      e.preventDefault();
      var order_id   =  $(this).data('id');
      $.ajax({
        url: "../search.php?type=checkout",
        type: "GET",
        data:{order_id:order_id},
        success:function(data){
          if (data == 1) {
            Swal.fire({
              icon: 'success',
              text: 'X??c nh???n thanh to??n th??nh c??ng',
              showConfirmButton: false,
              timer: 1200
            }).then((result) => {
              if (result.isConfirmed == false) {
                  window.location = "order.php";
              }
            });
          } else{
            Swal.fire({
              icon: 'error',
              text: 'X??c nh???n thanh to??n th???t b???i',
              showConfirmButton: false,
              timer: 1200
            });
          }
        }
      });
    }
  })
</script>
<!-- change information -->
<script type="text/javascript">
  $(document).ready(function(){
    $('#information').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        url  : '../search.php?type=profileadmin',
        type : 'post',
        data : new FormData(this),
        processData: false,
        contentType: false,
        success:function(data){
          if (data == 1) {
            Swal.fire({
              icon: 'success',
              text: 'C???p nh???t th??nh c??ng!',
              showConfirmButton: false,
              timer: 1000
            }).then((result) => {
                if (result.isConfirmed == false) {
                    location.reload();
                }
            });
          }
        }
      })
    })
  })
</script>
<!-- change pass -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#password-old').blur(function(){
            var pass_old = $('#password-old').val();
            $.ajax({
                url  : '../search.php?type=checkpassadmin',
                type : 'post',
                data : {pass_old:pass_old},
                success:function(data){
                    if (data == 0) {
                        $('#error-pass').text("M???t kh???u kh??ng ????ng");
                    } else {
                        $('#error-pass').text("");
                    }
                }
            });
        });
        $('#re-password').blur(function(){
            var pass_new = $('#password-new').val(),
                re_pass  = $('#re-password').val();
            if (pass_new != re_pass) {
                $('#error-repass').text("Nh???p l???i m???t kh???u kh??ng kh???p");
            } else {
                $('#error-repass').text("");
            }
        });
        $('#fchangepass').submit(function(e){
            e.preventDefault();
            if ($('#error-repass').text() == "" && $('#error-pass').text() == "") {
                var pass_new = $('#password-new').val();
                $.ajax({
                    url  : '../search.php?type=changepassadmin',
                    type : 'post',
                    data : {pass_new:pass_new},
                    success:function(data){
                        if (data == 1) {
                          Swal.fire({
                            icon: 'success',
                            text: '?????i m???t kh???u th??nh c??ng!',
                            showConfirmButton: false,
                            timer: 1000
                          }).then((result) => {
                              if (result.isConfirmed == false) {
                                  location.reload();
                              }
                          });
                        }
                    }
                });
            }
        });
    });
</script>
<!-- chart -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var listday = $('#areaChart').data('list-day');
    var listmoney = $('#areaChart').data('money');
    var listmoneyall = $('#areaChart').data('money-all');
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    var areaChartData = {
      labels  : listday,
      datasets: [
        {
          label               : '???? thanh to??n',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : listmoney
        },
        {
          label               : '???? x??c nh???n',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : listmoneyall
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

  })
</script>
</body>
</html>