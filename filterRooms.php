<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>  
    
    <style>
    html, body {
    max-width: 100%;
    overflow-x: hidden;
}
 
    
    </style>
  </head>
<body id=''>
  <center>
  <input type="radio" name="week" value="M"> M
  <input type="radio" name="week" value="T"> T
  <input type="radio" name="week" value="W"> W
  <input type="radio" name="week" value="R"> R
  <input type="radio" name="week" value="F"> F
  <br />
    <input type='number' id='hour' placeholder='Hour' />:<input type='number' id='minute' placeholder='Minute' /><br />
    <button onclick='grabClasses()'>
      Search
    </button>    
    <button onclick='fillFields()'>
      Now
    </button>
  </center>
<script type='text/javascript'>
    function fillFields(){
      var radios = document.getElementsByName('week');

      for (var i = 0, length = radios.length; i < length; i++){
        if (radios[i].value == <?php 
                $day = date("l");
                if($day == "Thursday"){
                  $day = "R";
                }else{
                  $day = $day[0];
                }
              echo "'$day'";
            
            ?>){
              radios[i].checked = true;
            }
      }
      document.getElementById("hour").value = <?php echo date('H')-3; ?>;
      document.getElementById("minute").value = <?php echo date('i'); ?>;
    }
    function grabClasses(){
      var radios = document.getElementsByName('week');
      var day;
      for (var i = 0, length = radios.length; i < length; i++){
       if (radios[i].checked){day = radios[i].value;}
      }
      var time = document.getElementById("hour").value+""+document.getElementById("minute").value;
      
      $.ajax({
        type: 'get',
        url: "getRooms.php",
        data: {
            'day': day,
            'time': time
        },
        cache: false,
        success: function(data) {
          document.getElementById("result").innerHTML = data;
        }
    });
      
    }
</script>
  
    <script type='text/javascript'>
					function showDiv(popup){
            var popup  = document.getElementById(popup);
						popup.style.display = 'block';

					}
					function hideDiv(popup){
            var popup  = document.getElementById(popup);
						popup.style.display = 'none';

					}
				</script>
  
  
<div id='result'>
  
  </div>  

  <?php 
  	
  ?>
 
  </body>
</html>