<?php
	session_start();
	require 'lang.php';
  if (isset($_COOKIE['lang'])) 
  {
    $lang = $ar;
  }
  else 
  {
    $lang = $en;
  }
	$dsn = 'mysql:host=localhost;dbname=hotel';
	$user ='root';
	$pass = '';
	$option = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);
	try {
		$con = new PDO($dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

  /**
    *********************************
    ******** Page Log In ************
    *********************************
  */
  // Check If User Coming From HTTP Post Request
  if (isset($_POST['LogIn'])) 
  {
    if (isset($_POST['UserName']) && isset($_POST['Password'])) 
    {
      $employee = $con->prepare('SELECT * FROM employees WHERE UserName = ? AND Pass = ? AND Block = "false"');
      $employee->execute(array($_POST['UserName'], SHA1($_POST['Password'])));
      // If Count > 0 This Mean The Database Contain Record About This User
      if ($employee->rowCount() > 0)
      {
        $user = $employee->fetch();
        if ($user['Job'] == 'Admin')
        {
          $_SESSION['AdminId'] = $user['EmpId'];
          $_SESSION['Admin'] = $user['UserName'];
          echo 'admin';
        }
        else 
        {
          $_SESSION['ReceptionId'] = $user['EmpId'];
          $_SESSION['Reception'] = $user['UserName'];
          echo 'reception';
        }
      }
      else 
      {
        $client = $con->prepare('SELECT * FROM clients WHERE UserName = ? AND Pass = ?');
        $client->execute(array($_POST['UserName'], SHA1($_POST['Password'])));
        if ($client->rowCount() > 0)
        {
          $user = $client->fetch();
          $_SESSION['ClientId'] = $user['ClientId'];
          $_SESSION['Client'] = $user['UserName'];
          echo 'client';
        }
        else 
        {
          ?>
          <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
            <svg class="ErrorLogIn mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            <div>
              <?php echo $lang['Sorry:ThereIsAnErrorInTheUserNameOrPassword']; ?>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php
        }
      }
    }
		else 
		{
			echo http_response_code(501);
		}
  }

  /**********************************************************************
    ********************************
    ***** Handle Requset Floor *****
    ********************************
  */
	/**
    *********************************
	  ******** Show All Floors ********
    *********************************
  */
	if (isset($_POST['ShowFloor'])) 
	{
		$floorDisplay = $con->prepare('SELECT floors.FloorId, COUNT(flats.FlatId) AS FlatCount, employees.UserName FROM employees JOIN floors ON floors.AdminId = employees.EmpId LEFT JOIN flats ON floors.FloorId = flats.FloorId GROUP BY floors.FloorId');
		$floorDisplay->execute();
		if ($floorDisplay->rowCount() > 0) 
		{
      echo json_encode($floorDisplay->fetchAll());
		}
		else 
		{
      echo json_encode(array());
		}
	}

	/**
    **********************************
	  ******** Add New Floor ***********
    **********************************
  */
	if (isset($_POST['AddFloor'])) 
	{
		if(isset($_POST['FloorId']))
		{
			$_POST['FloorId'] = !is_numeric($_POST['FloorId']) ? 0 : $_POST['FloorId'];
      $InsertFloor = $con->prepare('INSERT INTO floors SET FloorId = ?, AdminId = ?');
      $InsertFloor->execute(array( $_POST['FloorId'] + 1, $_SESSION['AdminId']));
		}
		else 
		{
			echo http_response_code(501);
		}
	}

	/**
    *******************************
	  ****** Remove Last Floor ******
    *******************************
  */
	if (isset($_POST['RemoveFloor'])) 
	{
		if(isset($_POST['FloorId']))
		{
      $GetFlatsPhotos = $con->prepare("SELECT Images, MainImage FROM flats WHERE FloorId = ?");
      $GetFlatsPhotos->execute(array($_POST['FloorId']));
      if ($GetFlatsPhotos->rowCount() > 0) 
      {
        $Rows = $GetFlatsPhotos->fetchAll();
        foreach ($Rows as $Row) 
        {
          $Images = explode(",", $Row['Images']);
          $Images[] = $Row['MainImage'];
          for ($i = 0; $i < COUNT($Images); $i++) 
          {
            unlink('../photos/' . $Images[$i]);
          }
        }
      }
			$DeleteFloor = $con->prepare('DELETE FROM floors WHERE FloorId = ?');
			$DeleteFloor->execute(array($_POST['FloorId']));
		}
		else 
		{
			echo http_response_code(501);
		}
	}

  /***********************************************************************
    ********************************
    ***** Handle Requset Flat *****
    ********************************
  */

  /**
    *********************************
    ***** Set Arabic Language *******
    *********************************
  */
  if (isset($_POST['SetArabicLang'])) 
  {
    setcookie("lang", "ar", time() + (7 * 24 * 60 * 60), "/");
  }

  /**
    *********************************
    ***** Set English Language ******
    *********************************
  */
  if (isset($_POST['SetEnglishLang'])) 
  {
    setcookie("lang", "ar", time() - (7 * 24 * 60 * 60), "/");
  }

  /**
    **********************************
    ***** GET Flats To Home Page *****
    **********************************
  */
  if (isset($_POST['GETFlats']))
  {
    $Where = array();
    $Having = array();
    if (!empty($_POST['FloorId'])) 
    {
      $Where[] = "flats.FloorId = " . $_POST['FloorId'];
    }
    if (!empty($_POST['FlatId'])) 
    {
      $Where[] = "flats.FlatId = " . $_POST['FlatId'];
    }
    if (isset($_POST['View']) && $_POST['View'] != "All") 
    {
      $Where[] = "flats.View = '" . $_POST['View'] . "'";
    }
    if (!empty($_POST['RoomsCount'])) 
    {
      $Having[] = "RoomCount = " . $_POST['RoomsCount'];
    }
    if (!empty($_POST['BedsCount'])) 
    {
      $Having[] = "BedCount = " . $_POST['BedsCount'];
    }
    if (!empty($_POST['LowPrice']) && !empty($_POST['HeighPrice'])) 
    {
      $Having[] = "Price BETWEEN " . $_POST['LowPrice'] . " AND " . $_POST['HeighPrice'];
    }
    if (isset($_POST['Rate']) && $_POST['Rate'] > 0) 
    {
      $Having[] = "Rate = " . $_POST['Rate'];
    }
    $FlatDisplay = $con->prepare("SELECT 
    (
      SELECT SUM(Rooms.Quantity) FROM flat_features AS Rooms, hotel_features AS HotelRoom WHERE flats.FlatId = Rooms.FlatId 
      AND flats.FloorId = Rooms.FloorId AND Rooms.FeatureId = HotelRoom.Id AND HotelRoom.FeatureId = 1
    ) AS RoomCount,
    (
      SELECT SUM(Beds.Quantity) FROM flat_features AS Beds, hotel_features AS HotelBed WHERE flats.FlatId = Beds.FlatId 
      AND flats.FloorId = Beds.FloorId AND Beds.FeatureId = HotelBed.Id AND HotelBed.FeatureId = 3
    ) AS BedCount,
    (
      SELECT SUM(Price.Quantity * HotelPrice.Price) FROM flat_features AS Price, hotel_features AS HotelPrice WHERE flats.FlatId = Price.FlatId 
      AND flats.FloorId = Price.FloorId AND Price.FeatureId = HotelPrice.Id
    ) AS Price,
    (
      SELECT ROUND(AVG(booking.Rate)) FROM booking WHERE flats.FloorId = booking.FloorId AND flats.FlatId = booking.FlatId
    ) AS Rate,
    flats.* FROM flats " . (COUNT($Where) > 0 ? "WHERE " . implode(" AND ", $Where) : "") . 
    " GROUP BY flats.FloorId, flats.FlatId " . (COUNT($Having) > 0 ? "HAVING " . implode(" AND ", $Having) : ""));
    $FlatDisplay->execute();
    if ($FlatDisplay->rowCount() > 0)
    {
      echo json_encode($FlatDisplay->fetchAll());
    }
    else 
    {
      echo json_encode(array());
    }
  }

  /**
    **********************************
    ********* Show All Flat **********
    **********************************
  */
  if (isset($_POST['ShowFlat']))
  {
    if (isset($_POST['FloorId'])) 
    {
      $FlatDisplay = $con->prepare('SELECT SUM(flat_features.Quantity) AS RoomsCount, flats.*, employees.UserName FROM employees JOIN flats ON flats.AdminId = employees.EmpId JOIN flat_features ON flats.FlatId = flat_features.FlatId AND flats.FloorId = flat_features.FloorId JOIN hotel_features ON flat_features.FeatureId = hotel_features.Id WHERE flats.FloorId = ? AND hotel_features.FeatureId = 1 GROUP BY  flat_features.FloorId, flat_features.FlatId');
      $FlatDisplay->execute(array($_POST['FloorId']));
      if ($FlatDisplay->rowCount() > 0)
      {
        echo json_encode($FlatDisplay->fetchAll());
      }
      else 
      {
        echo json_encode(array());
      }
    }
    else
    {
      echo http_response_code(501);
    }
  }

	/**
    **********************************
	  ********** Add New Flat **********
    **********************************
  */
	if (isset($_POST['AddFlat']))
	{
		if (isset($_POST['FlatId']) && isset($_POST['FloorId']) && isset($_POST['Area']) && isset($_POST['View']) && isset($_FILES['MainImage']) && isset($_FILES['OtherImage']) && isset($_POST['Data'])) 
		{
      $GetFlatNumber = $con->prepare("SELECT * FROM flats WHERE FlatId = ? AND FloorId = ?");
      $GetFlatNumber->execute(array($_POST['FlatId'], $_POST['FloorId']));
      if ($GetFlatNumber->rowCount() == 0)
      {
        /*
          * Upload Main Image
        */
        $mainImg = rand(0, 10000000) . "_" . $_FILES['MainImage']['name'];
        move_uploaded_file($_FILES['MainImage']['tmp_name'], "../photos/" . $mainImg);
  
        /*
          * Upload Other Images
        */
        for ($i = 0; $i < COUNT($_FILES['OtherImage']['name']); $i++)
        { 
          $otherImg[$i] = rand(0, 10000000) . "_" . $_FILES['OtherImage']['name'][$i];
          move_uploaded_file($_FILES['OtherImage']['tmp_name'][$i], "../photos/" . $otherImg[$i]);
        }
        $CreateFlat = $con->prepare("INSERT INTO flats SET FloorId = ?, FlatId = ?, AdminId = ?, MainImage = ?, Images = ?, Area = ?, View = ?");
        $CreateFlat->execute(array($_POST['FloorId'], $_POST['FlatId'], $_SESSION['AdminId'], $mainImg, implode(",", $otherImg), $_POST['Area'], $_POST['View']));
        foreach ($_POST['Data'] as $key) 
        {
          $AddFlatFeatures = $con->prepare("INSERT INTO flat_features SET FeatureId = ?, FloorId = ?, FlatId = ?, Quantity = ?");
          $AddFlatFeatures->execute(array($key['FeatureId'], $_POST['FloorId'], $_POST['FlatId'], $key['Quantity']));
        }
        echo true;
      }
      else
      {
        echo false;
      }
		}
		else 
		{
			echo http_response_code(501);
		}
	}

  /**
    **********************************
    *********** Remove Flat **********
    **********************************
  */
  if (isset($_POST['RemoveFlat'])) 
  {
    if(isset($_POST['FloorId']) && isset($_POST['FlatId']))
		{
      $GetFlatsPhotos = $con->prepare("SELECT Images, MainImage FROM flats WHERE FloorId = ? AND FlatId = ?");
      $GetFlatsPhotos->execute(array($_POST['FloorId'], $_POST['FlatId']));
      $Rows = $GetFlatsPhotos->fetchAll();
      foreach ($Rows as $Row) 
      {
        $Images = explode(",", $Row['Images']);
        $Images[] = $Row['MainImage'];
        for ($i = 0; $i < COUNT($Images); $i++) 
        {
          unlink('../photos/' . $Images[$i]);
        }
      }
			$DeleteFlat = $con->prepare('DELETE FROM flats WHERE FloorId = ? AND FlatId = ?');
			$DeleteFlat->execute(array($_POST['FloorId'], $_POST['FlatId']));
		}
		else 
		{
			echo http_response_code(501);
		}
  }

  /**
    *********************************************
    * Get Primary Feature For Add Flta To Floor *
    *********************************************
  */
  if (isset($_POST['GetFeatures']))
  {
    $GetPrimaryFeature = $con->prepare("SELECT hotel_features.Id, hotel_features.Details, features.FeatureId, features.FeatureName FROM hotel_features JOIN features ON features.FeatureId = hotel_features.FeatureId");
    $GetPrimaryFeature->execute();
    if ($GetPrimaryFeature->rowCount() > 0)
    {
      $Data = $GetPrimaryFeature->fetchAll();
      foreach ($Data as $value) 
      {
        $Response[$value['FeatureName']][] = $value;
      }
      echo json_encode($Response);
    }
    else
    {
      echo json_encode(array());
    }
  }

  /***************************************************************
    ********************************
    ***** Handle Requset Feature ***
    ********************************
  */
  /**
    ********************************
    ***** Show All Feature *********
    ********************************
  */
  if (isset($_POST['ShowFeature'])) 
  {
    $FeatureDisplay = $con->prepare('SELECT hotel_features.*, features.FeatureName, employees.UserName FROM employees JOIN hotel_features ON hotel_features.AdminId = employees.EmpId JOIN features ON hotel_features.FeatureId = features.FeatureId');
		$FeatureDisplay->execute();
		if ($FeatureDisplay->rowCount() > 0) 
		{
			echo json_encode($FeatureDisplay->fetchAll());
		}
		else 
		{
			echo json_encode(array());
		}
  }

  /**
    ************************************
    ******** Add New Feature ***********
    ************************************
  */
  if (isset($_POST['AddFeature'])) 
  {
    if (isset($_POST['FeatureName']) && isset($_POST['Price']) && isset($_POST['Details'])) 
    {
      $CheckIfExsist = $con->prepare("SELECT * FROM hotel_features WHERE FeatureId = ? AND Details = ?");
      $CheckIfExsist->execute(array($_POST['FeatureName'], $_POST['Details']));
      if($CheckIfExsist->rowCount() > 0)
      {
        echo false;
      }
      else 
      {
        $InsertHotelFeature = $con->prepare("INSERT INTO hotel_features SET FeatureId = ?, Details = ?, Price = ?, AdminId = ?");
        $InsertHotelFeature->execute(array($_POST['FeatureName'], $_POST['Details'], $_POST['Price'], $_SESSION['AdminId']));
        echo true;
      }
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    **********************************
    ********** Edit Feature **********
    **********************************
  */
  if (isset($_POST['EditFeature'])) 
  {
    if (isset($_POST['Id']) && isset($_POST['FeatureId']) && isset($_POST['Price']) && isset($_POST['Details'])) 
    {
      $CheckIfExsist = $con->prepare("SELECT * FROM hotel_features WHERE FeatureId = ? AND Details = ? AND Id != ?");
      $CheckIfExsist->execute(array($_POST['FeatureId'], $_POST['Details'], $_POST['Id']));
      if($CheckIfExsist->rowCount() > 0)
      {
        echo false;
      }
      else 
      {
        $InsertHotelFeature = $con->prepare("UPDATE hotel_features SET FeatureId = ?, Details = ?, Price = ? WHERE Id = ?");
        $InsertHotelFeature->execute(array($_POST['FeatureId'], $_POST['Details'], $_POST['Price'], $_POST['Id']));
        echo true;
      }
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ******* Remove Feature ********
    *******************************
  */
  if (isset($_POST['RemoveFeature'])) 
  {
    if (isset($_POST['Id'])) 
    {
      $CheckIfWasUesd = $con->prepare(("SELECT * FROM flat_features WHERE FeatureId = ?"));
      $CheckIfWasUesd->execute(array($_POST['Id']));
      if ($CheckIfWasUesd->rowCount() > 0)
      {
        echo false;
      }
      else
      {
        $RemoveFeature = $con->prepare(("DELETE FROM hotel_features WHERE Id = ?"));
        $RemoveFeature->execute(array($_POST['Id']));
        echo true;
      }
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /****************************************************************
    ********************************
    ***** Handle Requset Setting ***
    ********************************
  */
  /**
    *********************************
    ****** Change Site Sittings *****
    *********************************
  */
  if (isset($_POST['ChangeSiteSittings'])) 
  {
    if (isset($_FILES['LogoImage']) && isset($_POST['EnglishHotelName']) && isset($_POST['ArabicHotelName']) && isset($_POST['SiteColors']) && isset($_POST['PageColor']) && isset($_POST['ElementColor']) && isset($_POST['TextPrimaryColor']) && isset($_POST['TextSecondaryColor']) && isset($_POST['InputBoxShadowColor']) && isset($_POST['OldTheme']) && isset($_POST['NewTheme']) && isset($_POST['EnglishAboutHotel']) && isset($_POST['ArabicAboutHotel'])) 
    {
      /*
        * Upload Logo
      */
      if (!empty($_FILES['LogoImage']['name']))
      {
        move_uploaded_file($_FILES['LogoImage']['tmp_name'], "../photos/logo.WebP");
      }

      /*
        * Change Hotel Name
      */
      $Search = array();
      $Replace = array();
      if ($en['HotelName'] != $_POST['EnglishHotelName']) 
      {
        $Search[] = "'HotelName' => '" . $en['HotelName'] . "'";
        $Replace[] = "'HotelName' => '" . $_POST['EnglishHotelName'] . "'";
      }
      if ($ar['HotelName'] != $_POST['ArabicHotelName']) 
      {
        $Search[] = "'HotelName' => '" . $ar['HotelName'] . "'";
        $Replace[] = "'HotelName' => '" . $_POST['ArabicHotelName'] . "'";
      }
      if ($en['About'] != $_POST['EnglishAboutHotel']) 
      {
        $Search[] = "'About' => '" . $en['About'] . "'";
        $Replace[] = "'About' => '" . $_POST['EnglishAboutHotel'] . "'";
      }
      if ($ar['About'] != $_POST['ArabicAboutHotel']) 
      {
        $Search[] = "'About' => '" . $ar['About'] . "'";
        $Replace[] = "'About' => '" . $_POST['ArabicAboutHotel'] . "'";
      }
      if (COUNT($Search) > 0 && COUNT($Replace) > 0) 
      {
        file_put_contents('lang.php', str_replace($Search, $Replace, file_get_contents('lang.php')));
      }
      
      /*
        * Change Site Colors
      */
      $Search = array();
      $Replace = array();
      if (!in_array($_POST['PageColor'], $_POST['SiteColors'])) 
      {
        $Search[] = "--color-BackgroundBody:" . $_POST['SiteColors'][0];
        $Replace[] = "--color-BackgroundBody:" . $_POST['PageColor'];
      }
      if (!in_array($_POST['ElementColor'], $_POST['SiteColors'])) 
      {
        $Search[] = "--color-BackgroundElement:" . $_POST['SiteColors'][1];
        $Replace[] = "--color-BackgroundElement:" . $_POST['ElementColor'];
      }
      if (!in_array($_POST['TextPrimaryColor'], $_POST['SiteColors'])) 
      {
        $Search[] = "--color-PrimaryText:" . $_POST['SiteColors'][2];
        $Replace[] = "--color-PrimaryText:" . $_POST['TextPrimaryColor'];
      }
      if (!in_array($_POST['TextSecondaryColor'], $_POST['SiteColors'])) 
      {
        $Search[] = "--color-SecondaryText:" . $_POST['SiteColors'][3];
        $Replace[] = "--color-SecondaryText:" . $_POST['TextSecondaryColor'];
      }
      if (!in_array($_POST['InputBoxShadowColor'], $_POST['SiteColors'])) 
      {
        $Search[] = "--color-InputBoxShadowSelect:" . $_POST['SiteColors'][4];
        $Replace[] = "--color-InputBoxShadowSelect:" . $_POST['InputBoxShadowColor'];
      }
      if (COUNT($Search) > 0 && COUNT($Replace) > 0) 
      {
        file_put_contents('../styles/main.css', str_replace($Search, $Replace, file_get_contents('../styles/main.css')));
      }

      /*
        * Change Hotel Images
      */
      $Search = array();
      $Replace = array();
      if (isset($_POST['RemoveImages']) || isset($_FILES['NewImages'])) 
      {
        if (isset($_POST['OldImages'])) 
        {
          $Images = $_POST['OldImages'];
          $Search[] = "OldHotelImages = ['" . implode("', '", $Images) . "']";
        }
        else 
        {
          $Images = array();
          $Search[] = "OldHotelImages = []";
        }
        if (isset($_POST['RemoveImages'])) 
        {
          foreach ($_POST['RemoveImages'] as $Item) 
          {
            unlink("../photos/" . $Images[$Item]);
            unset($Images[$Item]);
          }
        }
        if (isset($_FILES['NewImages'])) 
        {
          for ($i = 0; $i < COUNT($_FILES['NewImages']['name']); $i++) 
          {
            try 
            {
              $ImageName = rand() . "_" . $_FILES['NewImages']['name'][$i];
              move_uploaded_file($_FILES['NewImages']['tmp_name'][$i], "../photos/" . $ImageName);
              $Images[] = $ImageName;
            } 
            catch (Exception $e) 
            {
              echo $e->getMessage();
            }
          }
        }
        $Replace[] = COUNT($Images) > 0 ? "OldHotelImages = ['" . implode("', '", $Images) . "']" : "OldHotelImages = []";
      }

      /*
        * Change Table Theme
      */
      if ($_POST['OldTheme'] != $_POST['NewTheme']) 
      {
        $Search[] = "TableTheme = '" . $_POST['OldTheme'] . "'";
        $Replace[] = "TableTheme = '" . $_POST['NewTheme'] . "'";
      }
      if (COUNT($Search) > 0 && COUNT($Replace) > 0) 
      {
        file_put_contents('../scripts/new.js', str_replace($Search, $Replace, file_get_contents('../scripts/new.js')));
      }
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /*************************************************************************
    ********************************
    *** Handle Requset Employees ***
    ********************************
  */
  /**
    *********************************
    ****** Show All Employees *******
    *********************************
  */
  if (isset($_POST['ShowEmployees'])) 
  {
    $EmployeesDisplay = $con->prepare('SELECT Reception.*, employees.UserName AS AddedBy FROM employees AS Reception, employees WHERE Reception.AdminId = employees.EmpId and Reception.Job = "Reception"');
		$EmployeesDisplay->execute();
		if ($EmployeesDisplay->rowCount() > 0) 
		{
      echo json_encode($EmployeesDisplay->fetchAll());
		}
		else 
		{
			echo json_encode(array());
		}
  }

  /**
    **********************************
    ****** Add New Employees *********
    *********************************
  */
  if (isset($_POST['AddEmployees'])) 
  {
    if(isset($_POST['UserName']) && isset($_POST['Password']))
		{
      $CheckUserName = $con->prepare("SELECT * FROM employees WHERE UserName = ?");
      $CheckUserName->execute(array($_POST['UserName']));
      if ($CheckUserName->rowCount() == 0)
      {
        $InsertEmployee = $con->prepare('INSERT INTO employees SET UserName = ?, Pass = ?, AdminId = ?');
        $InsertEmployee->execute(array( $_POST['UserName'], SHA1($_POST['Password']), $_SESSION['AdminId']));
        echo true;
      }
      else 
      {
        echo false;
      }
		}
		else 
		{
			echo http_response_code(501);
		}
  }

  /**
    ************************************
    ******** Edit Employees ************
    ************************************
  */
  if (isset($_POST['EditEmployees'])) 
  {
    if(isset($_POST['EmpId']) && isset($_POST['UserName']) && isset($_POST['Password']))
		{
      $CheckUserName = $con->prepare("SELECT * FROM employees WHERE UserName = ? AND EmpId != ?");
      $CheckUserName->execute(array($_POST['UserName'], $_POST['EmpId']));
      if ($CheckUserName->rowCount() == 0)
      {
        if (!empty($_POST['Password'])) 
        {
          $Query = 'UPDATE employees SET UserName = ?, Pass = ? WHERE EmpId = ?';
          $Data = array($_POST['UserName'], SHA1($_POST['Password']), $_POST['EmpId']);
        }
        else
        {
          $Query = 'UPDATE employees SET UserName = ? WHERE EmpId = ?';
          $Data = array($_POST['UserName'], $_POST['EmpId']);
        }
        $InsertEmployee = $con->prepare($Query);
        $InsertEmployee->execute($Data);
        echo true;
      }
      else 
      {
        echo false;
      }
		}
		else 
		{
			echo http_response_code(501);
		}
  }

  /**
    ************************************
    ******** Block Employees ***********
    ************************************
  */
  if (isset($_POST['BlockEmployee']))
  {
    if (isset($_POST['id']))
    {
      $BlockEmployee = $con->prepare("UPDATE employees SET Block = 'true' WHERE EmpId = ?");
      $BlockEmployee->execute(array($_POST['id']));
      echo $BlockEmployee->rowCount() > 0 ? true : false;
    }
    else
    {
      echo http_response_code(501);
    }
    
  }

  /**
    ************************************
    ******** UnBlock Employees ***********
    ************************************
  */
  if (isset($_POST['UnBlockEmployee']))
  {
    if (isset($_POST['id']))
    {
      $UnBlockEmployee = $con->prepare("UPDATE employees SET Block = 'false' WHERE EmpId = ?");
      $UnBlockEmployee->execute(array($_POST['id']));
      echo $UnBlockEmployee->rowCount() > 0 ? true : false;
    }
    else
    {
      echo http_response_code(501);
    }
    
  }

  /*************************************************************************
    ********************************
    *** Handle Requset Services ***
    ********************************
  */
  /**
    *********************************
    ****** Show All Services *******
    *********************************
  */
  if (isset($_POST['ShowServices'])) 
  {
    $ServicesDisplay = $con->prepare('SELECT employees.UserName, services.* FROM services, employees WHERE services.AdminId = employees.EmpId');
		$ServicesDisplay->execute();
		if ($ServicesDisplay->rowCount() > 0) 
		{
      echo json_encode($ServicesDisplay->fetchAll());
		}
		else 
		{
			echo json_encode(array());
		}
  }

  /**
    *******************************
    ******* Add New Service *******
    *******************************
  */
  if (isset($_POST['AddService']))
  {
    if (isset($_POST['ServiceName']))
    {
      $CheckIfExsist = $con->prepare("SELECT * FROM services WHERE ServiceName = ?");
      $CheckIfExsist->execute(array($_POST['ServiceName']));
      if($CheckIfExsist->rowCount() > 0)
      {
        echo false;
      }
      else 
      {
        $InsertService = $con->prepare("INSERT INTO services SET ServiceName = ?, AdminId = ?");
        $InsertService->execute(array($_POST['ServiceName'], $_SESSION['AdminId']));
        echo true;
      }
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ******* Remove Service *******
    *******************************
  */
  if (isset($_POST['RemoveService']))
  {
    if (isset($_POST['Id'])) 
    {
      $RemoveService = $con->prepare(("DELETE FROM services WHERE serviceId = ?"));
      $RemoveService->execute(array($_POST['Id']));
    }
    else
    {
      echo http_response_code(501);
    }
  }

  
  /*************************************************************************
    ********************************
    ** Handle Requset Single-Flat **
    ********************************
  */
  /**
    *******************************
    **** Get All Data Of Flat *****
    *******************************
  */
  if (isset($_POST['GetDataFlat'])) 
  {
    if (isset($_POST['FloorId']) && isset($_POST['FlatId'])) 
    {
      $GetFlatBooking = $con->prepare("SELECT booking.EntryDate, booking.ExitDate, booking.AcceptDate FROM booking WHERE FloorId = ? AND FlatId = ? AND ExitDate >= CURDATE()");
      $GetFlatBooking->execute(array($_POST['FloorId'], $_POST['FlatId']));
      $Flat['Booking'] = $GetFlatBooking->fetchAll();
      $GetAllFeature = $con->prepare("SELECT hotel_features.Id, hotel_features.Details, features.FeatureId, features.FeatureName, flat_features.Quantity FROM features JOIN hotel_features ON features.FeatureId = hotel_features.FeatureId LEFT JOIN flat_features ON flat_features.FeatureId = hotel_features.Id AND flat_features.FloorId = ? AND flat_features.FlatId = ?");
      $GetAllFeature->execute(array($_POST['FloorId'], $_POST['FlatId']));
      $Data = $GetAllFeature->fetchAll();
      foreach ($Data as $value) 
      {
        $Response[$value['FeatureName']][] = $value;
      }
      $Flat['Features'] = $Response;
      $Flat['UserType'] = COUNT($_SESSION) > 0 ? array_keys($_SESSION)[1] : '';
      echo json_encode($Flat);
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ****** Update Flat Info *******
    *******************************
  */
  if (isset($_POST['UpdateFlatInfo'])) 
  {
    if (isset($_POST['OldFloorId']) && isset($_POST['OldFlatId']) && isset($_POST['NewFloorId']) && isset($_POST['NewFlatId']) && isset($_POST['View']) && isset($_POST['Area'])) 
    {
      if ($_POST['NewFloorId'] == $_POST['OldFloorId'] && $_POST['NewFlatId'] == $_POST['OldFlatId']) 
      {
        $Query = "UPDATE flats SET View = ?, Area = ? WHERE FloorId = ? AND FlatId = ?";
        $Params = array($_POST['View'], $_POST['Area'], $_POST['OldFloorId'], $_POST['OldFlatId']);
      }
      else 
      {
        $Query = "UPDATE flats SET FloorId = ?, FlatId = ?, View = ?, Area = ? WHERE FloorId = ? AND FlatId = ?";
        $Params = array($_POST['NewFloorId'], $_POST['NewFlatId'], $_POST['View'], $_POST['Area'], $_POST['OldFloorId'], $_POST['OldFlatId']);
      }
      try 
      {
        $UpdateFlatInfo = $con->prepare($Query);
        $UpdateFlatInfo->execute($Params);
        echo true;
      } 
      catch(\Throwable $th)
      {
        echo false;
      }
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ***** Update Flat Images ******
    *******************************
  */
  if (isset($_POST['UpdateFlatImage'])) 
  {
    if (isset($_POST['FloorId']) && isset($_POST['FlatId']) && isset($_FILES['Images'])) 
    {
      for ($i = 0; $i < COUNT($_FILES['Images']['name']); $i++)
      { 
        $otherImg[$i] = rand(0, 10000000) . "_" . $_FILES['Images']['name'][$i];
        move_uploaded_file($_FILES['Images']['tmp_name'][$i], "../photos/" . $otherImg[$i]);
      }
      $GetFlatImages = $con->prepare("SELECT Images FROM flats WHERE FloorId = ? AND FlatId = ?");
      $GetFlatImages->execute(array($_POST['FloorId'], $_POST['FlatId']));
      $NewImages = array_merge(explode(",", $GetFlatImages->fetchColumn()), $otherImg);
      $UpdateFlatImages = $con->prepare("UPDATE flats SET Images = ? WHERE FloorId = ? AND FlatId = ?");
      $UpdateFlatImages->execute(array(implode(",", $NewImages), $_POST['FloorId'], $_POST['FlatId']));
      // echo json_encode($otherImg);
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    *** Update Flat Main Image ****
    *******************************
  */
  if (isset($_POST['UpdateFlatMainImage'])) 
  {
    if (isset($_POST['FloorId']) && isset($_POST['FlatId']) && isset($_FILES['MainImage'])) 
    {
      $MainImage = rand(0, 10000000) . "_" . $_FILES['MainImage']['name'];
      move_uploaded_file($_FILES['MainImage']['tmp_name'], "../photos/" . $MainImage);
      $GetFlatMainImage = $con->prepare("SELECT MainImage FROM flats WHERE FloorId = ? AND FlatId = ?");
      $GetFlatMainImage->execute(array($_POST['FloorId'], $_POST['FlatId']));
      unlink('../photos/' . $GetFlatMainImage->fetchColumn());
      $UpdateFlatMainImage = $con->prepare("UPDATE flats SET MainImage = ? WHERE FloorId = ? AND FlatId = ?");
      $UpdateFlatMainImage->execute(array($MainImage, $_POST['FloorId'], $_POST['FlatId']));
      echo $MainImage;
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ***** Delete Flat Images ******
    *******************************
  */
  if (isset($_POST['DeleteFlatImage'])) 
  {
    if (isset($_POST['FloorId']) && isset($_POST['FlatId']) && isset($_POST['ImageName'])) 
    {
      unlink('../photos/' . $_POST['ImageName']);
      $GetFlatImages = $con->prepare("SELECT Images FROM flats WHERE FloorId = ? AND FlatId = ?");
      $GetFlatImages->execute(array($_POST['FloorId'], $_POST['FlatId']));
      $Images = explode(",", $GetFlatImages->fetchColumn());
      unset($Images[array_search($_POST['ImageName'], $Images)]);
      $UpdateFlatImages = $con->prepare("UPDATE flats SET Images = ? WHERE FloorId = ? AND FlatId = ?");
      $UpdateFlatImages->execute(array(implode(",", $Images), $_POST['FloorId'], $_POST['FlatId']));
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ****** Add Flat Feature *******
    *******************************
  */
  if (isset($_POST['AddFlatFeature'])) 
  {
    if (isset($_POST['FloorId']) && isset($_POST['FlatId']) && isset($_POST['Quantity']) && isset($_POST['FeatureId'])) 
    {
      $AddFlatFeatures = $con->prepare("INSERT INTO flat_features SET FeatureId = ?, FloorId = ?, FlatId = ?, Quantity = ?");
      $AddFlatFeatures->execute(array($_POST['FeatureId'], $_POST['FloorId'], $_POST['FlatId'], $_POST['Quantity']));
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ***** Delete Flat Feature *****
    *******************************
  */
  if (isset($_POST['DeleteFlatFeature'])) 
  {
    if (isset($_POST['FloorId']) && isset($_POST['FlatId']) && isset($_POST['FeatureId'])) 
    {
      $DeleteFlatFeatures = $con->prepare("DELETE FROM flat_features WHERE FeatureId = ? AND FloorId = ? AND FlatId = ?");
      $DeleteFlatFeatures->execute(array($_POST['FeatureId'], $_POST['FloorId'], $_POST['FlatId']));
    }
    else
    {
      echo http_response_code(501);
    }
  }

  /**
    *******************************
    ******* Add New Booking *******
    *******************************
  */
  if (isset($_POST['AddBooking'])) 
  {
    if (isset($_SESSION['Client'])) 
    {
      if (isset($_POST['FloorId']) && isset($_POST['FlatId']) && isset($_POST['EntryDate']) && isset($_POST['ExitDate']) && isset($_POST['FinalPrice'])) 
      {
        $InsertBooking = $con->prepare("INSERT INTO booking SET FloorId = ?, FlatId = ?, ClientId = ?, EntryDate = ?, ExitDate = ?, BookingDate = now(), FinalPrice = ?");
        $InsertBooking->execute(array($_POST['FloorId'], $_POST['FlatId'], $_SESSION['ClientId'], $_POST['EntryDate'], $_POST['ExitDate'], $_POST['FinalPrice']));
        echo true;
      }
      else
      {
        echo http_response_code(501);
      }
    }
    else 
    {
      if (isset($_POST['FloorId']) && isset($_POST['FlatId']) && isset($_POST['UserName']) && isset($_POST['Password']) && isset($_POST['Phone']) && isset($_POST['NationalId']) && isset($_POST['Email']) && isset($_FILES['ID']) && isset($_POST['EntryDate']) && isset($_POST['ExitDate']) && isset($_POST['FinalPrice'])) 
      {
        try 
        {
          $ID = rand(0, 10000000) . "_" . $_FILES['ID']['name'];
          $InsertClient = $con->prepare("INSERT INTO clients SET UserName = ?, Phone = ?, NationalId = ?, Pass = ?, ID = ?, Email = ?");
          $InsertClient->execute(array($_POST['UserName'], $_POST['Phone'], $_POST['NationalId'], SHA1($_POST['Password']), $ID, $_POST['Email']));
          $CLientId = $con->lastInsertId();
          move_uploaded_file($_FILES['ID']['tmp_name'], "../photos/" . $ID);
          $InsertBooking = $con->prepare("INSERT INTO booking SET FloorId = ?, FlatId = ?, ClientId = ?, EntryDate = ?, ExitDate = ?, BookingDate = now(), FinalPrice = ?");
          $InsertBooking->execute(array($_POST['FloorId'], $_POST['FlatId'], $CLientId, $_POST['EntryDate'], $_POST['ExitDate'], $_POST['FinalPrice']));
          $_SESSION['ClientId'] = $CLientId;
          $_SESSION['Client'] = $_POST['UserName'];
          echo true;
        } 
        catch (\Throwable $th) 
        {
          if (file_exists("../photos/" . $ID))
          {
            unlink("../photos/" . $ID);
          }
          echo false;
        }
      }
      else
      {
        echo http_response_code(501);
      }
    }
  }

  /***************************************************************
    ********************************
    ******** Handle Function *******
    ********************************
  */
	/*
	** Function To Count Number Of Items Rows
	** $item = The Item To Count
	** $table = The Table To Choose From
  ** $where = The Condietion Of The SQL query
	*/
	function countItems($item, $table, $where = '')
	{
		global $con;
		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table $where");
		$stmt2->execute();
		return $stmt2->fetchColumn();
	}
