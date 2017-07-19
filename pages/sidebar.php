
<?php
include_once '../functions/functions.php';

if(!isset($_SESSION['user_id']))
{
  header("Location: login.php");  
}
?>
<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <!--<a class="sidebar-brand" href="#"><span class="highlight">Flat v3</span> Admin</a>-->
    <button type="button" class="sidebar-toggle">
      <i class="fa fa-times"></i>
    </button>  
  </div>
  <div class="sidebar-menu">
    <ul class="sidebar-nav">
      <?php
      if($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 3)
      {
        echo " <li id ='dashboard'>
        <a href='./index.php'> 
          <div class='icon'>
            <i class='fa fa-tasks' aria-hidden='true'></i>
          </div>
          <div class='title'>Dashboard</div>
        </a>
      </li> ";
      }  
      ?>
      




       <li id ="categorisation" class="@@menu.categorisation">
        <a href="./categorisation.php">
          <div class="icon">
            <i class="fa fa-comments" aria-hidden="true"></i>
          </div>
          <div class="title">Categorisation</div>
        </a> 
      </li>
      <li id ="grouping" class="@@menu.grouping">
        <a href="./grouping.php">
          <div class="icon">
            <i class="fa fa-comments" aria-hidden="true"></i>
          </div>
          <div class="title">Grouping</div>
        </a>
      </li> 

      <?php
      if($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 3)
      {
        echo "<li id='admin' class='dropdown'>
        <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
          <div class='icon'>
            <i class='fa fa-cube' aria-hidden='true'></i>
          </div> 
          <div class='title'>Admin</div>
        </a>
        <div class='dropdown-menu'>
          <ul>  
            <li class='section'><i class='fa fa-file-o' aria-hidden='true'></i>Users</li>
            <li><a href='./users.php'>View Users</a></li>     
            <li class='line'></li>
            <li class='section'><i class='fa fa-file-o' aria-hidden='true'></i>Shop Management</li>
            <li><a href='./uikits/pricing-table.php'>Retailers</a></li>
            <!-- <li><a href='./uikits/timeline.php'>Timeline</a></li> -->
            <li><a href='./uikits/chart.php'>Software Companies</a></li>
          </ul>
        </div>
      </li>";
      }
      ?>
      

      <!-- <li class="dropdown ">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-cube" aria-hidden="true"></i>
          </div> 
          <div class="title">UI Kits</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> UI Kits</li>
            <li><a href="./uikits/customize.php">Customize</a></li>
            <li><a href="./uikits/components.php">Components</a></li>
            <li><a href="./uikits/card.php">Card</a></li>
            <li><a href="./uikits/form.php">Form</a></li>
            <li><a href="./uikits/table.php">Table</a></li>
            <li><a href="./uikits/icons.php">Icons</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Advanced Components</li>
            <li><a href="./uikits/pricing-table.php">Pricing Table</a></li>
             <li><a href="./uikits/timeline.php">Timeline</a></li>
            <li><a href="./uikits/chart.php">Chart</a></li>
          </ul>
        </div>
      </li> --> 
      <!-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-file-o" aria-hidden="true"></i>
          </div>
          <div class="title">Pages</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Admin</li>
            <li><a href="./pages/form.php">Form</a></li>
            <li><a href="./pages/profile.php">Profile</a></li>
            <li><a href="./pages/search.php">Search</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Landing</li>
           
            <li><a href="./pages/login.php">Login</a></li>
            <li><a href="./pages/register.php">Register</a></li>
            
          </ul> 
        </div>
      </li> -->
    </ul>
  </div>
  <!-- <div class="sidebar-footer">
    <ul class="menu">
      <li>
        <a href="/" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-cogs" aria-hidden="true"></i>
        </a>
      </li>
      <li><a href="#"><span class="flag-icon flag-icon-th flag-icon-squared"></span></a></li>
    </ul>
  </div> -->
</aside>

<script type="text/ng-template" id="sidebar-dropdown.tpl.php">
  <div class="dropdown-background">
    <div class="bg"></div>
  </div>
  <div class="dropdown-container">
    {{list}}
  </div>
</script> 

<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-collapse collapse in">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        </li>
        <li class="logo">
          <!--<a class="navbar-brand" href="#"><span class="highlight">Flat v3</span> Admin</a>-->
        </li>
        <li>
          <button type="button" class="navbar-toggle">
            <img class="profile-img" src="./assets/images/profile.png">
          </button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title">Dashboard</li>
        <li class="navbar-search hidden-sm">
          <input id="search" type="text" placeholder="Search..">
          <button class="btn-search"><i class="fa fa-search"></i></button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown notification">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
            <div class="title">New Orders</div>
            <div class="count">0</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Ordering</li>
              <li class="dropdown-empty">No New Ordered</li>
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>
        <li class="dropdown notification warning">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-comments" aria-hidden="true"></i></div>
            <div class="title">Unread Messages</div>
            <div class="count">99</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Message</li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">10</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Payment Confirmation.."</div>
                      <div class="description">Alan Anderson</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">5</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Hello World"</div>
                      <div class="description">Marco  Harmon</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-warning pull-right">2</span>
                  <div class="message">
                    <img class="profile" src="https://placehold.it/100x100">
                    <div class="content">
                      <div class="title">"Order Confirmation.."</div>
                      <div class="description">Brenda Lawson</div>
                    </div>
                  </div>  
                </a>
              </li>
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>
        <li class="dropdown notification danger">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <div class="icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
            <div class="title">System Notifications</div>
            <div class="count">10</div>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li class="dropdown-header">Notification</li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">8</span>
                  <div class="message">
                    <div class="content">
                      <div class="title">New Order</div>
                      <div class="description">$400 total</div>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">14</span>
                  Inbox
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">5</span>
                  Issues Report
                </a>
              </li>
              <li class="dropdown-footer">
                <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
              </li>
            </ul>
          </div>
        </li>
        <li class="dropdown profile">
          <a href="/html/pages/profile.php" class="dropdown-toggle"  data-toggle="dropdown">
            <img class="profile-img" src="../assets/images/profile.png">
            <div class="title">Profile</div>
          </a>
          <div class="dropdown-menu">
            <div class="profile-info">
              <h4 class="username">Scott White</h4>
            </div>
            <ul class="action">
              <li>
                <a href="#">
                  Profile
                </a>
              </li>
              <li>
                <a href="#">
                  <span class="badge badge-danger pull-right">5</span>
                  My Inbox
                </a>
              </li>
              <li>
                <a href="#">
                  Setting
                </a>
              </li>
              <li onclick="logout()">
                  <a href="#"> 
                  Logout
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

 