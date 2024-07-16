<?php include ('../config.php');



$page = isset($_POST['Page']) && is_numeric($_POST['Page']) ? $_POST['Page'] : 1;
$records_per_page = isset($_POST['perpg']) && in_array($_POST['perpg'], [25, 50, 75, 100]) ? $_POST['perpg'] : 10;
$offset = ($page - 1) * $records_per_page;

$statement = "SELECT * from panel_health a INNER JOIN sites b ON a.atmid = b.ATMID AND b.live='Y' where 1 ";


// Apply filters
if (!empty($_REQUEST['customer'])) {
  $customer = $_REQUEST['customer'];
  $statement .= "AND b.Customer LIKE '%$customer%' ";
}
if (!empty($_REQUEST['atmid'])) {
  $atmid = $_REQUEST['atmid'];
  $statement .= "AND a.atmid LIKE '%$atmid%' ";
}

if (!empty($_REQUEST['panelip'])) {
  $panelip = $_REQUEST['panelip'];
  $statement .= "AND a.ip LIKE '%$panelip%' ";
}
if (!empty($_REQUEST['panelName'])) {
  $panelName = $_REQUEST['panelName'];
  $statement .= "AND a.panelName LIKE '%$panelName%' ";
}

$withoutLimitsql = $statement;
$sqlCount = mysqli_query($con, $statement);
$total_records = mysqli_num_rows($sqlCount);

$statement .= "LIMIT $offset, $records_per_page";
$sql = mysqli_query($con, $statement);


// echo $statement ; 
?>
<br><br>
<div class="card">
  <div class="card-body">

    <div class="total_n_export" style="display: flex;
    justify-content: space-between;">

      <h6 class="mb-0 text-uppercase">Total Records : <?php echo $total_records; ?> </h6>

      <div class="button-list">

        <button type="button" style="background:#fd3550 !important; color:white;" class=""> 1 - Alert</button>

        <button type="button" style="background-color:#15ca20;color:white;" class=""> 0 - Normal </button>

        <button type="button" style="background-color:orchid;" class="">9 - ByPassed</button>

        <button type="button" style="background-color:white;color:black;border: 2px solid black" color="red" class="">2
          -
          Disconnect</button>
      </div>

      <form action="./exportrecordsrms.php">
        <input type="hidden" name="exportsql" value="<?php echo $withoutLimitsql; ?>">
        <button type="submit" class="btn btn-outline-info px-5 radius-30"><i
            class="bx bx-cloud-download mr-1"></i>Export
        </button>
      </form>

    </div>


    <hr>

    <div class="records">

      <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
          <tr class="table-primary">
            <th>SN</th>
            
            <th>
              <div>Client</div>
            </th>
            <th>
              <div>Site Name</div>
            </th>

            <th>
              <div>State&nbsp; </div>
            </th>
            <th>
              <div>City&nbsp; </div>
            </th>
            <th>
              <div>Bank&nbsp; </div>
            </th>
            <th>
              <div>PanelIP&nbsp; </div>
            </th>
            <th>
              <div>Panel Name&nbsp; </div>
            </th>
            <th>
              <div>Date_Time&nbsp; </div>
            </th>
            <th>
              <div style="" id="">LobbyPIR Motion Sensor</div>
            </th>
            <th>
              <div style="" id="">Glass Break Sensor</div>
            </th>
            <th>
              <div style="" id="">Panic Switch</div>
            </th>
            <th>
              <div style="" id="">MainDoor shuttNormal NO type</div>
            </th>

            <th>
              <div id="">ATM1 Removal</div>
            </th>
            <th>
              <div id="">ATM 1 Vibration</div>
            </th>
            <th>
              <div id="">SmokeDetector 12V IN +</div>
            </th>
            <th>
              <div id="">Videoloss/Video Temper/HDD alarm</div>
            </th>
            <th>
              <div style="" id="">ATM 1 Thermal/Heat</div>
            </th>
            <th>
              <div style="" id="">ATM 2 Thermal/Heat</div>
            </th>
            <th>
              <div id="">ChestDoor Open ATM1</div>
            </th>
            <th>
              <div style="" id="">ChestDoor Open ATM2</div>
            </th>
            <th>
              <div style="" id="">ChestDoor Open ATM3</div>
            </th>
            <th>
              <div style="" id="">AC /UPS removal</div>
            </th>

            <th>
              <div style="" id="">Cheque dropbox removal</div>
            </th>
            <th>
              <div id="">Chequedrop box open</div>
            </th>
            <th>
              <div style="" id="">CCTV 1+2+3 Removal</div>
            </th>
            <th>
              <div id="">ATM 3 Thermal/ Heat</div>
            </th>
            <th>
              <div style="" id="">Backroom Door Open</div>
            </th>
            <th>
              <div id="">Lobby Temprature SensorHigh</div>
            </th>
            <th>
              <div id="">ATM 1/2 HoodDoor Sensor</div>
            </th>
            <th>
              <div style="" id="">LobbyTemprature Sensor Low</div>
            </th>
            <th>
              <div id="">Silence Key</div>
            </th>
            <th>
              <div style="" id="">AC Mains Fail DI</div>
            </th>
            <th>
              <div id="">UPS O/P FailDI</div>
            </th>
            <th>
              <div style="" id="">Panel Tamper Switch</div>
            </th>



            <th>
              <div style="" id="">Low Battery</div>
            </th>
            <th>
              <div style="" id="">No battery</div>
            </th>
            <th>
              <div id="">Fire TroubleSmoke sense</div>
            </th>
            <th>
              <div id="">CURRENT STATUS</div>
            </th>
            <th>
              <div>SiteAddress&nbsp; </div>
            </th>
          </tr>
        </thead>

        <tbody>

          <?php
          $i = 1 + $offset; // Adjust index based on current page and offset
          
          while ($row = mysqli_fetch_array($sql)) {

            $StateQry = mysqli_query($conn, "select State,PanelIP,City,SiteAddress,Bank,Customer from sites where ATMID='" . $row['atmid'] . "'");

            $fetchState = mysqli_fetch_array($StateQry);


            ?>
            <tr <?php if ($row[67] == 1) { ?> class="dangeralertClass" <?php } else if ($row[67] == 0) { ?>
                  class="successalertClass" <?php } ?>>
              <td><?php echo $i; ?></td>
              <td><?php echo $fetchState['Customer']; ?></td>
              <td><?php echo $row[68]; ?></td>


              <td><?php echo $fetchState['State']; ?></td>
              <td><?php echo $fetchState['City']; ?></td>
              <td><?php echo $fetchState['Bank']; ?></td>

              <td><?php echo $fetchState['PanelIP']; ?></td>
              <td><?php echo $row['panelName']; ?></td>
              <td><?php echo $row[0]; ?></td>
              <td align="center">
                <div id="">
                  <?php if ($row[4] == 0) {
                    echo "Normal";
                  } else if ($row[4] == 1) {
                    echo "Alert";
                  } else if ($row[4] == 2) {
                    echo "Disconnect";
                  } else if ($row[4] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[5] == 0) {
                    echo "Normal";
                  } else if ($row[5] == 1) {
                    echo "Alert";
                  } else if ($row[5] == 2) {
                    echo "Disconnect";
                  } else if ($row[5] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[6] == 0) {
                    echo "Normal";
                  } else if ($row[6] == 1) {
                    echo "Alert";
                  } else if ($row[6] == 2) {
                    echo "Disconnect";
                  } else if ($row[6] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[7] == 0) {
                    echo "Normal";
                  } else if ($row[7] == 1) {
                    echo "Alert";
                  } else if ($row[7] == 2) {
                    echo "Disconnect";
                  } else if ($row[7] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[8] == 0) {
                    echo "Normal";
                  } else if ($row[8] == 1) {
                    echo "Alert";
                  } else if ($row[8] == 2) {
                    echo "Disconnect";
                  } else if ($row[8] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[9] == 0) {
                    echo "Normal";
                  } else if ($row[9] == 1) {
                    echo "Alert";
                  } else if ($row[9] == 2) {
                    echo "Disconnect";
                  } else if ($row[9] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <!--<td align="center"><div id=""><?php if ($row[10] == 0) {
                echo "Normal";
              } else if ($row[10] == 1) {
                echo "Alert";
              } else if ($row[10] == 2) {
                echo "Disconnect";
              } else if ($row[10] == 9) {
                echo "By Passed";
              } ?></div></td>
        <td align="center"><div id=""><?php if ($row[11] == 0) {
          echo "Normal";
        } else if ($row[11] == 1) {
          echo "Alert";
        } else if ($row[11] == 2) {
          echo "Disconnect";
        } else if ($row[11] == 9) {
          echo "By Passed";
        } ?></div></td>
        <td align="center"><div id=""><?php if ($row[12] == 0) {
          echo "Normal";
        } else if ($row[12] == 1) {
          echo "Alert";
        } else if ($row[12] == 2) {
          echo "Disconnect";
        } else if ($row[12] == 9) {
          echo "By Passed";
        } ?></div></td>
        <td align="center"><div id=""><?php if ($row[13] == 0) {
          echo "Normal";
        } else if ($row[13] == 1) {
          echo "Alert";
        } else if ($row[13] == 2) {
          echo "Disconnect";
        } else if ($row[13] == 9) {
          echo "By Passed";
        } ?></div></td>
       -->
              <td align="center">
                <div id="">
                  <?php if ($row[14] == 0) {
                    echo "Normal";
                  } else if ($row[14] == 1) {
                    echo "Alert";
                  } else if ($row[14] == 2) {
                    echo "Disconnect";
                  } else if ($row[14] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[15] == 0) {
                    echo "Normal";
                  } else if ($row[15] == 1) {
                    echo "Alert";
                  } else if ($row[15] == 2) {
                    echo "Disconnect";
                  } else if ($row[15] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[16] == 0) {
                    echo "Normal";
                  } else if ($row[16] == 1) {
                    echo "Alert";
                  } else if ($row[16] == 2) {
                    echo "Disconnect";
                  } else if ($row[16] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[17] == 0) {
                    echo "Normal";
                  } else if ($row[17] == 1) {
                    echo "Alert";
                  } else if ($row[17] == 2) {
                    echo "Disconnect";
                  } else if ($row[17] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[18] == 0) {
                    echo "Normal";
                  } else if ($row[18] == 1) {
                    echo "Alert";
                  } else if ($row[18] == 2) {
                    echo "Disconnect";
                  } else if ($row[18] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[19] == 0) {
                    echo "Normal";
                  } else if ($row[19] == 1) {
                    echo "Alert";
                  } else if ($row[19] == 2) {
                    echo "Disconnect";
                  } else if ($row[19] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[20] == 0) {
                    echo "Normal";
                  } else if ($row[20] == 1) {
                    echo "Alert";
                  } else if ($row[20] == 2) {
                    echo "Disconnect";
                  } else if ($row[20] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[21] == 0) {
                    echo "Normal";
                  } else if ($row[21] == 1) {
                    echo "Alert";
                  } else if ($row[21] == 2) {
                    echo "Disconnect";
                  } else if ($row[21] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[22] == 0) {
                    echo "Normal";
                  } else if ($row[22] == 1) {
                    echo "Alert";
                  } else if ($row[22] == 2) {
                    echo "Disconnect";
                  } else if ($row[22] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[23] == 0) {
                    echo "Normal";
                  } else if ($row[23] == 1) {
                    echo "Alert";
                  } else if ($row[23] == 2) {
                    echo "Disconnect";
                  } else if ($row[23] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[24] == 0) {
                    echo "Normal";
                  } else if ($row[24] == 1) {
                    echo "Alert";
                  } else if ($row[24] == 2) {
                    echo "Disconnect";
                  } else if ($row[24] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[25] == 0) {
                    echo "Normal";
                  } else if ($row[25] == 1) {
                    echo "Alert";
                  } else if ($row[25] == 2) {
                    echo "Disconnect";
                  } else if ($row[24] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[26] == 0) {
                    echo "Normal";
                  } else if ($row[26] == 1) {
                    echo "Alert";
                  } else if ($row[26] == 2) {
                    echo "Disconnect";
                  } else if ($row[26] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[27] == 0) {
                    echo "Normal";
                  } else if ($row[27] == 1) {
                    echo "Alert";
                  } else if ($row[27] == 2) {
                    echo "Disconnect";
                  } else if ($row[27] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[28] == 0) {
                    echo "Normal";
                  } else if ($row[28] == 1) {
                    echo "Alert";
                  } else if ($row[28] == 2) {
                    echo "Disconnect";
                  } else if ($row[28] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[29] == 0) {
                    echo "Normal";
                  } else if ($row[29] == 1) {
                    echo "Alert";
                  } else if ($row[29] == 2) {
                    echo "Disconnect";
                  } else if ($row[29] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[30] == 0) {
                    echo "Normal";
                  } else if ($row[30] == 1) {
                    echo "Alert";
                  } else if ($row[30] == 2) {
                    echo "Disconnect";
                  } else if ($row[30] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <!--<td align="center"><div id=""><?php if ($row[31] == 0) {
                echo "Normal";
              } else if ($row[31] == 1) {
                echo "Alert";
              } else if ($row[31] == 2) {
                echo "Disconnect";
              } else if ($row[31] == 9) {
                echo "By Passed";
              } ?></div></td>-->
              <td align="center">
                <div id="">
                  <?php if ($row[32] == 0) {
                    echo "Normal";
                  } else if ($row[32] == 1) {
                    echo "Alert";
                  } else if ($row[32] == 2) {
                    echo "Disconnect";
                  } else if ($row[32] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[33] == 0) {
                    echo "Normal";
                  } else if ($row[33] == 1) {
                    echo "Alert";
                  } else if ($row[33] == 2) {
                    echo "Disconnect";
                  } else if ($row[33] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <!--<td align="center"><div id=""><?php if ($row[34] == 0) {
                echo "Normal";
              } else if ($row[34] == 1) {
                echo "Alert";
              } else if ($row[34] == 2) {
                echo "Disconnect";
              } else if ($row[34] == 9) {
                echo "By Passed";
              } ?></div></td>
        <td align="center"><div id=""><?php if ($row[35] == 0) {
          echo "Normal";
        } else if ($row[35] == 1) {
          echo "Alert";
        } else if ($row[35] == 2) {
          echo "Disconnect";
        } else if ($row[35] == 9) {
          echo "By Passed";
        } ?></div></td>
        <td align="center"><div id=""><?php if ($row[36] == 0) {
          echo "Normal";
        } else if ($row[36] == 1) {
          echo "Alert";
        } else if ($row[36] == 2) {
          echo "Disconnect";
        } else if ($row[36] == 9) {
          echo "By Passed";
        } ?></div></td>-->
              <td align="center">
                <div id="">
                  <?php if ($row[37] == 0) {
                    echo "Normal";
                  } else if ($row[37] == 1) {
                    echo "Alert";
                  } else if ($row[37] == 2) {
                    echo "Disconnect";
                  } else if ($row[37] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[64] == 0) {
                    echo "Normal";
                  } else if ($row[64] == 1) {
                    echo "Alert";
                  } else if ($row[64] == 2) {
                    echo "Disconnect";
                  } else if ($row[64] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[65] == 0) {
                    echo "Normal";
                  } else if ($row[65] == 1) {
                    echo "Alert";
                  } else if ($row[65] == 2) {
                    echo "Disconnect";
                  } else if ($row[65] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[66] == 0) {
                    echo "Normal";
                  } else if ($row[66] == 1) {
                    echo "Alert";
                  } else if ($row[66] == 2) {
                    echo "Disconnect";
                  } else if ($row[66] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td align="center">
                <div id="">
                  <?php if ($row[67] == 0) {
                    echo "Normal";
                  } else if ($row[67] == 1) {
                    echo "Alert";
                  } else if ($row[67] == 2) {
                    echo "Disconnect";
                  } else if ($row[67] == 9) {
                    echo "By Passed";
                  } ?>
                </div>
              </td>
              <td><?php echo $fetchState['SiteAddress']; ?></td>
            </tr>
            <?php
            $i++;
            ?>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<?php
$total_pages = ceil($total_records / $records_per_page);
$filters = http_build_query(['atmid' => $_POST['atmid'], 'customer' => $_POST['customer'], 'panelip' => $_POST['panelip']]);

if ($total_pages > 1) {
  echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
  if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(1, ' . $records_per_page . ');">First</a></li>';
  }
  if ($page > 1) {
    echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(' . ($page - 1) . ', ' . $records_per_page . ');">Previous</a></li>';
  }
  $start = max(1, $page - 2);
  $end = min($total_pages, $page + 2);
  for ($i = $start; $i <= $end; $i++) {
    echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="#tabletop" onclick="a(' . $i . ', ' . $records_per_page . ');">' . $i . '</a></li>';
  }
  if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(' . ($page + 1) . ', ' . $records_per_page . ');">Next</a></li>';
  }
  if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="#tabletop" onclick="a(' . $total_pages . ', ' . $records_per_page . ');">Last</a></li>';
  }
  echo '</ul></nav>';
}
?>