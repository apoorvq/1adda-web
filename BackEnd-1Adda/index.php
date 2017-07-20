<html>
  <head>
    <link rel="stylesheet" type="text/css" href="indexStyle.css"/>
    <script src="jquery-3.2.1.min.js"></script>
  </head>
  <body>
    <div id="main" >
      <div class="blocks" id="block-1" ><p class="text">Mentors</p>
        <div class="options" id="options:1">
          <a class="option-name" href="Mentor/addMentor.html">Add</a>
          <a class="option-name" href="Mentor/viewMentor.php">View</a>
        </div>
      </div>
      <div class="blocks" id="block-2" ><p class="text">Advisors</p>
        <div class="options" id="options:2">
          <a class="option-name" href="Advisors/addAdvisor.html">Add</a>
          <a class="option-name" href="Advisors/viewAdvisor.php">View</a>
        </div>
      </div>
      <div class="blocks" id="block-3" ><p class="text">Blog</p>
        <div class="options" id="options:3">
          <a class="option-name" href="Blog/addBlog.html">Add</a>
          <a class="option-name" href="Blog/viewBlog.php">View</a>
        </div>
      </div>
      <div class="blocks" id="block-4" ><p class="text">Careers</p>
        <div class="options" id="options:4">
          <a class="option-name" href="Careers/addCareer.php">Add</a>
          <a class="option-name" href="Careers/viewCareer.php">View</a>
        </div>
      </div>
      <div class="blocks" id="block-5" ><p class="text">Events</p>
        <div class="options" id="options:5">
          <a class="option-name" href="Events/addEvent.html">Add</a>
          <a class="option-name" href="Events/viewEvent.php">View</a>
        </div>
      </div>
      <div class="blocks" id="block-6" ><p class="text">Partners</p>
        <div class="options" id="options:6">
          <a class="option-name" href="Partners/addPartner.php">Add</a>
          <a class="option-name" href="Partners/viewPartner.php">View</a>
        </div>
      </div>
      <div class="blocks" id="block-8" ><p class="text">Weekly Stories</p>
        <div class="options" id="options:8">
          <a class="option-name" href="WeeklyStories/addWeeklyStories.php">Add</a>
          <a class="option-name" href="WeeklyStories/viewWeeklyStory.php">View</a>
        </div>
      </div>
      <div class="blocks" id="block-7" style="bottom:37px;"><p class="text">Start-Ups</p>
        <div class="options" id="options:7">
          <a class="option-name" href="Startups/addStartups.php">Add</a>
          <a class="option-name" href="Startups/viewStartup.php">View</a>
        </div>
      </div>
    </div>
  </body>
  <script>
    $(document).ready(function(){
      $('.blocks').hover(function(){
        $(this).children('.options').slideDown('slow');

      });

    });
  </script>

  </script>
</html>
