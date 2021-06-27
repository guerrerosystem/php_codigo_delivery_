<html>
<body>
<footer class="main-footer">
    <div class="pull-right hidden-xs"></div>
   
</footer>
</div>

   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
    
    
    <script src="https://rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/extensions/export/bootstrap-table-export.min.js"></script>
    
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    
   
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
   
    <script src="bootstrap/js/bootstrap.min.js"></script>
  
    <script src="plugins/morris/morris.min.js"></script>
   
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    
    <script src="plugins/knob/jquery.knob.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
 
    <script src="plugins/fastclick/fastclick.min.js"></script>
    
    <script src="dist/js/app.min.js"></script>
    
    <script src="dist/js/demo.js"></script>
    
    
    
    
    <script>
    $(function () {
        
        $(".select").select2();
        });
    </script>
    <script>
   
    var url = window.location;

   
    $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
    }).addClass('active');


    $('ul.nav-treeview a').filter(function() {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
</script>
    </body>
</html>