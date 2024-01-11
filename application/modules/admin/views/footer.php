<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center text-lg-left text-muted">
              &copy; <?=date("Y");?> <a href="#" class="font-weight-bold ml-1" target="_blank"><?php echo get_store_name(); ?></a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <!-- <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script> -->
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

  <script>
  $('#datatable').DataTable( {
      dom: "<'row p-0 m-0'<'col-sm-12 mb-4 mt-2'B>>"+
           "lftrip",
      lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "Semua"]],
      buttons: [
          {
            extend: 'excel',
            title: function(data){
              return "<?=$title;?>"
            },
            messageTop: function(data){
              return "Tanggal "+$("input[name='order_start_date']").val()+" s/d "+$("input[name='order_end_date']").val()
            }

          }, 
          {
            extend: 'pdf',
            title: function(data){
              return "<?=$title;?>"
            },
            messageTop: function(data){
              return "Tanggal "+$("input[name='order_start_date']").val()+" s/d "+$("input[name='order_end_date']").val()
            }

          }, 
          {
            extend: 'print',
            title: function(data){
              return "<?=$title;?>"
            },
            messageTop: function(data){
              return "Tanggal "+$("input[name='order_start_date']").val()+" s/d "+$("input[name='order_end_date']").val()
            }
          }
      ]
  } );
</script>

  <!-- Argon JS -->
  <script src="<?php echo get_theme_uri('js/argon9f1e.js?v=1.1.0', 'argon'); ?>"></script>
</body>
</html>