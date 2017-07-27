<hr>

      <footer>
        <p>&copy; Ngọc Võ 2017</p>
      </footer>
    </div> <!-- /container -->

	
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="js/script.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function(){

      //Hide cac thong bao popup
       setTimeout(function(){
        $('.alert').hide(2000);
      }, 5000);

       //Set active cho page
      function stripTrailingSlash(str) {
        if(str.substr(-1) == '/') {
          return str.substr(0, str.length - 1);
        }
          return str;
      }

      var url = window.location.pathname;  
      var activePage = stripTrailingSlash(url);
      activePage = activePage.split('/');
      activePage = activePage[2];

      $('.navbar-nav li a').each(function(){  
        var currentPage = stripTrailingSlash($(this).attr('href'));

        if (activePage == currentPage) {
          $(this).parent().addClass('active'); 
        } 
      });
  });
  </script>
</body>
</html>