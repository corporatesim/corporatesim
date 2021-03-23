<?php include_once 'includes/jsheader.php'; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>

<HEAD>
  <META NAME="description" content="Hare and hounds is a PC-Game written in HTML and JavaScript">
  <META NAME="author" content="HUmanlinks">
  <META NAME="keywords" content="Game, Hare and hounds, JavaScript">

<!-- adding sweet alert -->
<link href="<?php echo site_root;?>dist/sweetalert/sweetalert2.min.css?v=1.1" rel="stylesheet" type="text/css">
<link href="<?php echo site_root;?>dist/sweetalert/animate.min.css?v=1.1" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css?v=1.1"> -->
<script src="<?php echo site_root;?>dist/sweetalert/sweetalert2.all.min.js?v=1.1"></script>
  <title>Simulation: Hare and Hound</title>
  <script src="js/jquery.min.js?v=<?php echo version; ?>"></script>
  <script language="JavaScript">
    var i, I_From, I_To, IsOver, Start, Start0 = 1;

    // today = new Date();
    clickJson = {};
    clickedOnImage = 0;
    clickedOnHound = 0;
    clickedOnHare = 0;
    IsPlayer = new Array(2);
    IsPlayer[0] = false; // for hare
    IsPlayer[1] = true; // for hounds
    Level = new Array(2);
    Level[0] = 2;
    Level[1] = 2;
    totalClicks = 0;
    winLoss = -1; // this means user submitted without completion. So, nither win nor loss

    Fld = new Array(11);

    Img2Fld = new Array(1, 4, 7, 0, 2, 5, 8, 10, 3, 6, 9);
    Fld2Img = new Array(3, 0, 4, 8, 1, 5, 9, 2, 6, 10, 7);

    CanGo = new Array(2);
    for (i = 0; i < 2; i++) CanGo[i] = new Array(11);
    //Hare can go from to
    CanGo[0][0] = new Array(1, 2, 3);
    CanGo[0][1] = new Array(0, 2, 4, 5);
    CanGo[0][2] = new Array(0, 1, 3, 5);
    CanGo[0][3] = new Array(0, 2, 5, 6);
    CanGo[0][4] = new Array(1, 5, 7);
    CanGo[0][5] = new Array(1, 2, 3, 4, 6, 7, 8, 9);
    CanGo[0][6] = new Array(3, 5, 9);
    CanGo[0][7] = new Array(4, 5, 8, 10);
    CanGo[0][8] = new Array(5, 7, 9, 10);
    CanGo[0][9] = new Array(5, 6, 8, 10);
    CanGo[0][10] = new Array(7, 8, 9);
    //Hounds can go from to
    CanGo[1][0] = new Array(1, 2, 3);
    CanGo[1][1] = new Array(2, 4, 5);
    CanGo[1][2] = new Array(1, 3, 5);
    CanGo[1][3] = new Array(2, 5, 6);
    CanGo[1][4] = new Array(5, 7);
    CanGo[1][5] = new Array(4, 6, 7, 8, 9);
    CanGo[1][6] = new Array(5, 9);
    CanGo[1][7] = new Array(8, 10);
    CanGo[1][8] = new Array(7, 9, 10);
    CanGo[1][9] = new Array(8, 10);
    CanGo[1][10] = new Array();

    Pic = new Array(5);
    for (i = 0; i < 5; i++) {
      Pic[i] = new Image();
      Pic[i].src = "jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds" + i + ".gif";
    }

    function SetStart(ss) {
      Start0 = ss;
    }

    function SetPlayer(ii, nn) {
      IsPlayer[ii] = nn;
    }

    function SetLevel(ii, nn) {
      Level[ii] = parseInt(nn);
    }

    function Init() {
      // console.log('init');
      var ii;
      clickedOnImage = 0;
      clickedOnHound = 0;
      clickedOnHare = 0;

      startDateTime = new Date();
      var start_date = startDateTime.getFullYear() + '-' + (startDateTime.getMonth() + 1) + '-' + startDateTime.getDate();
      var start_time = startDateTime.getHours() + ":" + startDateTime.getMinutes() + ":" + startDateTime.getSeconds();

      clickJson['startedOn'] = start_date + ' ' + start_time;
      clickJson['startedOnDDMM'] = startDateTime.getDate() + ':' + (startDateTime.getMonth() + 1);
      Start = Start0;
      for (ii = 0; ii < 11; ii++) Fld[ii] = -1;
      Fld[10] = 0;
      Fld[0] = 1;
      Fld[1] = 1;
      Fld[3] = 1;
      I_From = -1;
      I_To = -1;
      IsOver = 0;
      MoveCount = 0;
      document.OptionsForm.Moves.value = MoveCount;
      MaxMoveCount = 0;
      N_Sel = -1;
      RefreshScreen();
    }

    function Timer() {
      if (IsOver) return;
      var mmove = (MoveCount + Start) % 2;
      if (IsPlayer[mmove]) return;
      GetBestMove(mmove, 2 + Level[mmove]);
      MakeMove(I_From, I_To);
    }

    function MakeMove(ff, tt) {
      Fld[tt] = Fld[ff];
      Fld[ff] = -1;
      RefreshPic(ff);
      RefreshPic(tt);
      I_From = -1;
      MoveCount++;
      document.OptionsForm.Moves.value = MoveCount;
      OverTest(Fld[tt], true);
    }

    function Clicked(ii, el) {
      var nn, mmove = (MoveCount + Start) % 2;
      // console.log(clickJson);
      // console.log('IsOver: '+IsOver);
      // console.log(IsPlayer[mmove]);
      // console.log('clicked on: '+Fld[ii]); // 0-for rabbit(hare), 1-for dog(hound), and -1 for blank image click 
      if (IsOver > 0) return;
      if (!IsPlayer[mmove]) return;
      if (Fld[ii] == 1 - mmove) return;
      // console.log(Fld[ii]);

      // adding seprate click count date wise
      if ($(el).attr('src')) {
        countDateTime = new Date();
        var count_date = countDateTime.getFullYear() + '-' + (countDateTime.getMonth() + 1) + '-' + countDateTime.getDate();
        var count_time = countDateTime.getHours() + ":" + countDateTime.getMinutes() + ":" + countDateTime.getSeconds();
        // console.log(count_date+' '+count_time);
        var clickedImageSrc = $(el).attr('src');
        clickedImageSrc = clickedImageSrc.split('/');
        clickedImageSrc = clickedImageSrc.pop() // getting the last value of array, which is image name
        clickJson[count_date + ' ' + count_time] = clickedImageSrc;
      }
      // end of adding seprate click count date wise

      switch (Fld[ii]) {
        case -1:
          clickedOnImage = clickedOnImage + 1;
          clickJson['clickedOnImage'] = clickedOnImage;
          break;
        case 1:
          clickedOnHound = clickedOnHound + 1;
          clickJson['clickedOnHound'] = clickedOnHound;
          break;
        case 0:
          hareClick = (IsPlayer[0]) ? clickedOnHare + 1 : 0; // if not automoved then 0
          clickJson['clickedOnHare'] = hareClick;
          break;
      }

      if (I_From >= 0) {
        if (Fld[ii] == mmove) {
          nn = I_From;
          I_From = ii;
          RefreshPic(nn);
          RefreshPic(ii);
          return;
        }
        for (nn = 0; nn < CanGo[mmove][I_From].length; nn++) {
          if (CanGo[mmove][I_From][nn] == ii) {
            MakeMove(I_From, ii);
            return;
          }
        }
        return;
      }

      if (Fld[ii] == mmove) {
        I_From = ii;
        RefreshPic(ii);
        return;
      }

      if (mmove == 1) return;

      for (nn = 0; nn < CanGo[mmove][ii].length; nn++) {
        if (Fld[CanGo[mmove][ii][nn]] == mmove) {
          I_From = CanGo[mmove][ii][nn];
          MakeMove(I_From, ii);
          return;
        }
      }
    }

    function GetBestMove(mmove, llevel) {
      if (mmove == 0) GetBestMoveHare(0, llevel, 30000);
      else GetBestMoveHounds(0, llevel, 30000);
    }

    function GetBestMoveHare(ll, mm, vv_cut) {
      var ii, jj, hhound, hhare = 0,
        iibest, vvbest = ll * 1000 - 10000;
      if (ll == mm) {
        for (ii = 10; ii >= 0; ii--) {
          if (Fld[ii] == 1) hhound = ii;
        }
      }
      while (Fld[hhare] != 0) hhare++;
      for (ii = 0; ii < CanGo[0][hhare].length; ii++) {
        jj = CanGo[0][hhare][ii];
        if (Fld[jj] < 0) {
          Fld[jj] = 0;
          Fld[hhare] = -1;
          if (ll < mm) vv = -GetBestMoveHounds(ll + 1, mm, -vvbest);
          else {
            if (Math.floor((hhare + 2) / 3) <= Math.floor((hhound + 2) / 3)) vv = 1000;
            else {
              vv = Math.random() * 10 - hhare;
              if (Fld[10] == 1) vv += 100;
              if (Fld[8] == 1) vv += 50;
            }
          }
          Fld[hhare] = 0;
          Fld[jj] = -1;
          if (vv > vv_cut) return (vv);
          if (vv > vvbest) {
            vvbest = vv;
            iibest = ii;
          }
        }
      }
      if (ll == 0) {
        I_From = hhare;
        I_To = CanGo[0][hhare][iibest];
      }
      return (vvbest);
    }

    function GetBestMoveHounds(ll, mm, vv_cut) {
      var ii, jj = 0,
        kk, hhare = 0,
        hhounds = new Array(3),
        iibest, kkbest, vvbest = ll * 1000 - 10000;
      if (ll == mm) {
        while (Fld[hhare] != 0) hhare++;
      }
      for (ii = 0; ii < 11; ii++) {
        if (Fld[ii] == 1) hhounds[jj++] = ii;
      }
      for (kk = 0; kk < 3; kk++) {
        for (ii = 0; ii < CanGo[1][hhounds[kk]].length; ii++) {
          jj = CanGo[1][hhounds[kk]][ii];
          if (Fld[jj] < 0) {
            Fld[jj] = 1;
            Fld[hhounds[kk]] = -1;
            if (ll < mm) vv = -GetBestMoveHare(ll + 1, mm, -vvbest);
            else {
              vv = hhare - Math.random() * 10;
              if (Fld[10] == 1) vv -= 100;
              if (Fld[8] == 1) vv -= 50;
            }
            Fld[hhounds[kk]] = 1;
            Fld[jj] = -1;
            if (vv > vv_cut) return (vv);
            if (vv > vvbest) {
              vvbest = vv;
              iibest = ii;
              kkbest = kk;
            }
          }
        }
      }
      if (ll == 0) {
        I_From = hhounds[kkbest];
        I_To = CanGo[1][hhounds[kkbest]][iibest];
      }
      return (vvbest);
    }

    function OverTest(mmove, mmsg) {
      if(mmove == undefined && mmsg == undefined)
      {
        submitInputsOfJsGame(clickJson);
      }
      var ii, hhare, hhound;
      for (ii = 10; ii >= 0; ii--) {
        if (Fld[ii] == 0) hhare = ii;
        if (Fld[ii] == 1) hhound = ii;
      }
      IsOver = true;
      winLoss = 1; // hare -> 0-win, 1-loss
      if (mmove == 0) //hare
      {
        if (Math.floor((hhare + 2) / 3) > Math.floor((hhound + 2) / 3)) IsOver = false;
        if ((mmsg) && (IsOver)) {
          winLoss = 0;
          alert("The hare has won !");
        }
      } else //hounds
      {
        for (ii = 0; ii < CanGo[0][hhare].length; ii++) {
          if (Fld[CanGo[0][hhare][ii]] == -1) IsOver = false;
        }
        if ((mmsg) && (IsOver)) {
          winLoss = 1;
          alert("The hounds have won !");
        }
      }
      if ((!IsOver) && (MoveCount == 49)) {
        IsOver = true;
        if (mmsg) {
          winLoss = 0;
          alert("The hare has won !");
        }
      }
      if (IsOver) {
        completeDateTime = new Date();
        var complete_date = completeDateTime.getFullYear() + '-' + (completeDateTime.getMonth() + 1) + '-' + completeDateTime.getDate();
        var complete_time = completeDateTime.getHours() + ":" + completeDateTime.getMinutes() + ":" + completeDateTime.getSeconds();
        var milisec = completeDateTime.getTime() - startDateTime.getTime(); // time in milisec
        clickJson['completedOn'] = complete_date + ' ' + complete_time;
        clickJson['completedOnDDMM'] = completeDateTime.getDate() + ':' + (completeDateTime.getMonth() + 1);
        clickJson['differenceInTime'] = Math.floor((milisec / 3600000)) + ':' + Math.floor((milisec / 60000)) + ':' + Math.floor((milisec / 1000) % 60); Math.floor(milisec / 1000)
        clickJson['differenceTimeInSec'] = Math.floor(milisec / 1000);
        clickJson['totalMoves'] = Math.floor(MoveCount / 2);
        clickJson['totalClicks'] = totalClicks;
        clickJson['winLoss'] = winLoss;
        
        // console.log(milisec +' and sec: '+ Math.floor(milisec / 1000));
        submitInputsOfJsGame(clickJson);
      }
      return (IsOver);
    }

    function RefreshPic(ii) {
      if (Fld[ii] < 0)
        window.document.images[Fld2Img[ii]].src = Pic[0].src;
      else {
        if (ii == I_From)
          window.document.images[Fld2Img[ii]].src = Pic[Fld[ii] + 3].src;
        else
          window.document.images[Fld2Img[ii]].src = Pic[Fld[ii] + 1].src;
      }
    }

    function RefreshScreen() {
      var ii;
      for (ii = 0; ii < 11; ii++) RefreshPic(ii);
    }

    function Help() {
      alert("The hounds try to trap the hare, so" +
        "\nthat it is unable to make any move." +
        "\nThe hare moves forward and backward" +
        "\nalong any vertical or diagonal line." +
        "\nThe hounds can only move forward.");
    }

    function Resize() {
      if (navigator.appName == "Netscape") history.go(0);
    }
    function submitInputsOfJsGame(gameData)
    {
      completeDateTime_sub = new Date();
      var complete_date_sub = completeDateTime_sub.getFullYear() + '-' + (completeDateTime_sub.getMonth() + 1) + '-' + completeDateTime_sub.getDate();
      var complete_time_sub = completeDateTime_sub.getHours() + ":" + completeDateTime_sub.getMinutes() + ":" + completeDateTime_sub.getSeconds();
      var milisec_sub = completeDateTime_sub.getTime() - startDateTime.getTime(); // time in milisec_sub
      clickJson['completedOn'] = complete_date_sub + ' ' + complete_time_sub;
      clickJson['completedOnDDMM'] = completeDateTime_sub.getDate() + ':' + (completeDateTime_sub.getMonth() + 1);
      clickJson['differenceInTime'] = Math.floor((milisec_sub / 3600000)) + ':' + Math.floor((milisec_sub / 60000)) + ':' + Math.floor((milisec_sub / 1000) % 60); Math.floor(milisec_sub / 1000)
      clickJson['differenceTimeInSec'] = Math.floor(milisec_sub / 1000);
      clickJson['totalMoves'] = Math.floor(MoveCount / 2);
      clickJson['totalClicks'] = totalClicks;
      clickJson['winLoss'] = winLoss;
        
      // console.log(gameData); return false;
      $.ajax({
        dataType: 'JSON',
        type: "POST",
        url: "<?php echo site_root; ?>mobile/CorpsimFormulaCalculation/saveJsInputs/" + <?php echo $linkid; ?> + "/" + <?php echo $gameid; ?> + "/" + <?php echo $userid; ?>,
        data: gameData,
        success: function(result) {
          // console.log(result);
          if(result.status == 200)
          {
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {
                'skipOutput': <?php echo ($result->Link_Enabled?$result->Link_Enabled:0); ?>,
                'userName': "<?php echo $_SESSION['username']; ?>"
              },
              url: "<?php echo site_root; ?>mobile/CorpsimFormulaCalculation/submitInput/" + <?php echo $linkid; ?> + "/" + <?php echo $gameid; ?> + "/" + <?php echo $userid; ?>,
              beforeSend: function() {
                Swal.fire({
                  title: 'Please Wait...',
                  width: 600,
                  padding: '3em',
                  showConfirmButton: false,
                  showCancelButton: false,
                  background: '#fff url(/images/trees.png)',
                  backdrop: `rgba(0,0,123,0.4)
                    url("/images/nyan-cat.gif")
                    left top
                    no-repeat`
                })
              },
              success: function(result) {
                console.log(result);
                // return 'mk';
                if (result.status == 200) {
                  window.location = "<?php echo site_root; ?>" + result.message;
                } else {
                  Swal.fire(result.message);
                }
              },
              error: function(jqXHR, exception) {
                {
                  $('.overlay').hide();
                  // alert(alert('error'+ jqXHR.status +" - "+exception));
                  Swal.fire({
                    icon: 'error',
                    html: jqXHR.responseText,
                  });
                  $("#input_loader").html('');
                  $('.overlay').hide();
                }
              }
            });
          }
          else
          {
            Swal.fire({
              icon: result.icon,
              title: result.title,
              html: result.message,
            });
          }
        }
      });
    }
  </script>
</head>

<BODY bgcolor=#bbccaa text=#000000 onResize="javascript:Resize()" oncontextmenu="return false" background="images/bg3.jpg">
  <h1 style="text-align: center;color: #fff;"></h1>

  <DIV ALIGN=center>
    <form name="OptionsForm">
      <table border=0 cellpadding=0 cellspacing=6 bgcolor=#996515>
        <tr>
          <td align=center bgcolor=#996515 background="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehoundsbg.gif">
            <nobr>
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" class="houndImage" width=108 height=108 border=0 onClick="javascript:Clicked(1,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(4,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(7,this)">
            </nobr>
            <br>
            <nobr>
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" class="houndImage" width=108 height=108 border=0 onClick="javascript:Clicked(0,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(2,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(5,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(8,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(10,this)">
            </nobr>
            <br>
            <nobr>
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" class="houndImage" width=108 height=108 border=0 onClick="javascript:Clicked(3,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(6,this)">
              <IMG src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds0.gif" width=108 height=108 border=0 onClick="javascript:Clicked(9,this)"></nobr>
          </td>
        </tr>
      </table>

      <table noborder cellpadding="2" cellspacing="2" hidden>
        <tr>
          <td>
            <table border="0" cellpadding="3" cellspacing="2" bgcolor="#808080">
              <tr>
                <td rowspan="2" bgcolor="#c0c0c0">
                  <img src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds2.gif" width=72 height=72></td>
                <td width=90 bgcolor=#DDDDDD><input type=radio name="Hounds" checked value="Player" onClick="javascript:SetPlayer(1,true)"><B>Player</B></td>
              </tr>
              <tr>
                <td bgcolor=#DDDDDD>
                  <table border=0 cellpadding=0 cellspacing=1>
                    <tr>
                      <td><input type=radio name="Hounds" value="Computer" onClick="javascript:SetPlayer(1,false)"><B>Computer</B></td>
                    </tr>
                    <tr>
                      <td align=right><SELECT NAME="HareLevel" onChange="SetLevel(1, this.options[selectedIndex].value)" SIZE=1>
                          <OPTION VALUE=1>Level 1
                          <OPTION VALUE=2 selected>Level 1
                          <OPTION VALUE=3>Level 1
                          <OPTION VALUE=4>Level 1
                        </SELECT></td>
                    </tr>
                  </table>
                </td>
              </tr>
          </td>
        </tr>
      </table>
      </td>
      <td>
        <table border=0 cellpadding=2 cellspacing=2 bgcolor=#808080>
          <tr bgcolor=#c0c0c0>
            <td colspan=2 align=center><B>Who moves first:</B></td>
          </tr>
          <tr bgcolor=#DDDDDD>
            <td width=83><input type=radio name="Start" checked value="Hounds" onClick="javascript:SetStart(1)"><B>Hounds</B></td>
            <td width=83><input type=radio name="Start" value="Hare" onClick="javascript:SetStart(0)"><B>Hare</B></td>
          </tr>
          <tr bgcolor=#DDDDDD>
            <td align=center colspan=2>
              <table border=0 cellpadding=0 cellspacing=0 width=162>
                <tr>
                  <td align=center><input type=button value="&nbsp;New&nbsp;" style="width:60" onClick="javascript:Init()"></td>
                  <td align=center><input type=button value="&nbsp;&nbsp;&nbsp;&nbsp;" style="width:40;background-color:#FFFFFF;font-weight:bold" disabled name="Moves" id="Moves"></td>
                  <td align=center><input type=button value="&nbsp;Help&nbsp;" style="width:60" onClick="javascript:Help()"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
      <td>
        <table border=0 cellpadding=3 cellspacing=2 bgcolor=#808080>
          <tr>
            <td rowspan=2 bgcolor=#c0c0c0>
              <img src="jsgames/<?php echo $findJsMapping[0]->Js_Name;?>/gameMedia/harehounds1.gif" width=72 height=72></td>
            <td width=90 bgcolor=#DDDDDD><input type=radio name="Hare" value="Player" onClick="javascript:SetPlayer(0,true)"><B>Player</B></td>
          </tr>
          <tr>
            <td bgcolor=#DDDDDD>
              <table border=0 cellpadding=0 cellspacing=1>
                <tr>
                  <td><input type=radio name="Hare" value="Computer" checked onClick="javascript:SetPlayer(0,false)"><B>Computer</B></td>
                </tr>
                <tr>
                  <td align=right><SELECT NAME="HareLevel" onChange="SetLevel(0, this.options[selectedIndex].value)" SIZE=1>
                      <OPTION VALUE=1>Level 1
                      <OPTION VALUE=2 selected>Level 1
                      <OPTION VALUE=3>Level 1
                      <OPTION VALUE=4>Level 1
                    </SELECT></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
      </tr>
      </table>
    </form>
  </DIV>
  <!-- submit button -->
  <!-- <button type="button" onclick="return OverTest();" style="position: fixed; right: 0%; transition: 0.3s; padding: 5px; width: auto; text-decoration: none; font-size: 14px; font-weight: 400; border-radius: 4px; color: white; font-weight: bold; background-color: #d9534f; border-color: #d43f3a; transform: rotate(-90deg); cursor:pointer;"><?php echo $result->Link_ButtonText; ?></button> -->

  <a class="rotateCompAnti" href="javascript:void(0);" style="padding-left: 120px; margin-top: 0px; position: fixed; right: -125px; transition: 0.3s; padding: 5px; width: 300px; text-decoration: none; font-size: 20px; color: white; border-radius: 0 5px 5px 0; font-weight: bold;">
    <button class="btn btn-danger" id="submitBtn" type="button" onclick="return OverTest();" ><?php echo $result->Link_ButtonText; ?></button>
  </a>
  <!-- description button -->
  <a title="This will open in new tab" class="" target="_blank" href="<?php echo $scenurl.'&close=true'; ?>" id="description"><button style="position: fixed; left: -20px; transition: 0.3s; padding: 5px; width: auto; text-decoration: none; font-size: 14px; border-radius: 4px; color: white; background-color: #f0ad4e; border-color: #eea236; transform: rotate(-90deg);"> Description</button></a>

  <script language="JavaScript">
    Init();
    setInterval("Timer()", 800);
  </script>
</BODY>
<p style="text-align: center;color: #fff;font-size: 15px;"></p>
<script>
  $(document).ready(function() {
    // alert('hello');
    $(document).on('click', function() {
      totalClicks++;
      // console.log(totalClicks);
    });
  });
</script>

</HTML>