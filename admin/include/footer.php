<footer class="main-footer">
</footer>  
</div>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
<script src="custom/custom.js"></script>
<script src="https://cdn.tiny.cloud/1/wnfamalcy2rutxy049cbmuvrrwymhdgs1k6ut0ql1ozgn6ji/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  $(function () {
    $('.DataTable').DataTable();
  })
</script>
<script type="text/javascript">
  tinymce.init({ 
  selector: '.textarea', 
  height: 300, 
  plugins: [ 
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  setup: function (editor) { 
    editor.on('change', function () { 
      tinymce.triggerSave(); 
    }); 
  } 
});

  var url = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
  $('.treeview-menu li').removeClass('active');
  $('[href$="'+url+'"]').parent().addClass("active");
  $('.treeview').removeClass('menu-open active');
  $('[href$="'+url+'"]').closest('li.treeview').addClass("menu-open active");

 
</script>
</body>
</html>