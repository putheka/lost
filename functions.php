
<?php

//function to upload image and returns the reference id
function upload_image($iname, $type)
{
    if(empty($_FILES[$iname]['name'])){
        $name="noimg.png";
        if ($type == 'lost')
            $query = "INSERT INTO limages(url) VALUES('$name')";

        if ($type == 'found')
            $query = "INSERT INTO fimages(url) VALUES('$name')";

        global $conn;
        $x = mysqli_query($conn, $query);
        $ref= mysqli_insert_id($conn);
        mysqli_commit($conn);
        return $ref;
    }



    //get file name here
    $_FILES[$iname]["name"] = $_SESSION['login_user'] . rand(100, 999) . $_FILES[$iname]["name"];
    $name = $_FILES[$iname]['name'];



    //chose post type
    if ($type == "lost") {
         $target_dir = "upload/lostimages/";
        

    }

    if ($type == "found") {
        $target_dir = "upload/foundimages/";

    }

    $target_file = $target_dir . basename($_FILES[$iname]["name"]);


    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("jpg", "jpeg", "png");

    // Check extension
    if (in_array($imageFileType, $extensions_arr)) {

        // Insert record

        if ($type == 'lost')
            $query = "INSERT INTO limages(url) VALUES('" . $name . "')";
        if ($type == 'found')
            $query = "INSERT INTO fimages(url) VALUES('" . $name . "')";

        global $conn;
        $x = mysqli_query($conn, $query);


        // Upload file

        move_uploaded_file($_FILES[$iname]['tmp_name'], $target_dir . $name);

        $ref= mysqli_insert_id($conn);
        mysqli_commit($conn);
        return $ref;
    } else
        return 'fail';
}

//function to insert adress and returns the reference id
function add_adress($Add)
{

    global $conn;
    $city = mysqli_real_escape_string($conn, $Add['city']);
    $loc = mysqli_real_escape_string($conn, $Add['street']);
    $pin = mysqli_real_escape_string($conn, $Add['pincode']);
    $phone = mysqli_real_escape_string($conn, $Add['phone']);


    $querry = "INSERT INTO `adress`( `mobile`, `pincode`, `city`, `state`) VALUES ('$phone','$pin','$city','$loc')";

    $x = mysqli_query($conn, $querry);
    $ref= mysqli_insert_id($conn);
    mysqli_commit($conn);
    return $ref;


}

//generates  categeory list
function gen_cat_list()
{
    $sql = "SELECT `cid`, `cname` FROM `catagoery`";
    global $conn;
    $retval = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $x = $row['cid'];
        $y = $row['cname'];
        echo "  <option value=\"$x\"  class=\"\" >$y</option>";
    }

}

//function to add post()
function add_post($discp, $ref_add, $pincode, $ref_uid, $ref_imgid, $date, $catg, $type)
{
    if ($type == "lost") {
        $sql = "INSERT INTO `lthings`(`cat_ref`, `discription`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`) VALUES ($catg,'$discp',$ref_add,$pincode,'$ref_uid',$ref_imgid,'$date')";
        // $sql="INSERT INTO `lthings`(`discription`,`loc_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`,`cat_ref`) VALUES ('$discp',$ref_add,$pincode,'$ref_uid',$ref_imgid,'$date',$catg)";
    }
    if ($type == "found") {
        $sql = "INSERT INTO `fthings`(`cat_ref`, `discription`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`) VALUES ($catg,'$discp',$ref_add,$pincode,'$ref_uid',$ref_imgid,'$date')";
    }

    global $conn;
    mysqli_query($conn, $sql);
    mysqli_commit($conn);

}

//function to get username by id
function get_user($id)
{
    global $conn;
    $sql = "SELECT  `fname`,`lname` FROM `user` WHERE `email`='$id' ";
    $retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);
    return $row['fname'] . " " . $row['lname'];
}

//get image url from id
function get_imgurl($id, $type)
{
    global $conn;

    if ($type == "lost")
        $sql = "SELECT  `url` FROM `limages` WHERE `id`=$id";
    else
        $sql = "SELECT  `url` FROM `fimages` WHERE `id`=$id";

    $retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);
    if ($type == "lost") {
        return "upload/lostimages/" . $row['url'];
    }
    if ($type == "found") {
        return "upload/foundimages/" . $row['url'];
    }

}

//get catageory  name by id
function get_catname($id)
{
    global $conn;
    $sql = "SELECT `cname` FROM `catagoery` WHERE `cid`=$id";
    $retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);
    return $row['cname'];
}

//function to retrive post
function get_post($id, $type)
{
    global $conn;
    if ($type == "lost") {
        $sql = "SELECT `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`,`draft` FROM `lthings` WHERE `id`=$id";
        $top = " <span class=\"losttitle  z-depth-1 \"><b>LOST</b></span>";
    } else {
        $sql = "SELECT `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft` FROM `fthings` WHERE `id`=$id";
        $top = "<span class=\"foundtitle  z-depth-1 \"><b>FOUND</b></span>";
    }

    $row = mysqli_fetch_array(mysqli_query($conn, $sql));
    if ($row['draft'] == 1) {
        $zz="<td><a class=\"btn\" href=\"\" disabled=''>drafted</a></td>";
    }
    else{
        $zz="<td><a class=\"btn\" href=\"draft.php?id=$id&&type=$type\">MOVE TO DRAFT</a></td>";
    }
    $catx=$row['cat_ref'];
    $cat = get_catname($row['cat_ref']);

    $disc = $row['discription'];

    // $add=$row['adressid'];
    //$pincode=$row['pincode'];
    //$user = get_user($row['uemail']);
    //$imgurl = get_imgurl($row['imgid'], $type);

    $pdate = $row['postdate'];

echo "<tr>
        <td>$id</td>
        <td>$type</td>
        <td>$cat</td>
        <td>$pdate</td>
        <td><a class=\"btn\" href=\"knowmore.php?id=$id&&type=$type\">Know more</a></td>
        
        $zz
        <td><a class=\"btn\" href=\"search.php?cat=$catx&&type=$type&&pdate=$pdate\">search</a></td>
        </tr>";
}

//function to retrive user post
function get_user_post($id, $type)
{

    global $conn;
    if ($type == "lost") {
        $sql = "SELECT `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`,`draft` FROM `lthings` WHERE `id`=$id";
        $top = " <span class=\"losttitle  z-depth-1 \"><b>LOST</b></span>";
    } else {
        $sql = "SELECT `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`,`draft` FROM `fthings` WHERE `id`=$id";
        $top = "<span class=\"foundtitle  z-depth-1 \"><b>FOUND</b></span>";
    }

    $row = mysqli_fetch_array(mysqli_query($conn, $sql));
    if ($row['draft'] == 1) {
        $link = " <a class= \"knoww btn btn-large teal\"  style=\" margin-top:10px\" href=\"knowmore.php?id=$id&&type=$type\">
                        SAVED IN DRAFT
                    </a>";
    } else {
        $link = " <a class=\"knoww btn btn-large  red lighten-1\" style=\" margin-top:10px\" href=\"draft.php?id=$id&&type=$type\">
                        Move to Draft
                    </a>";
    }
    $cat = get_catname($row['cat_ref']);
    $disc = $row['discription'];
    // $add=$row['adressid'];
    //$pincode=$row['pincode'];
    $user = get_user($row['uemail']);
    $imgurl = get_imgurl($row['imgid'], $type);
    $pdate = $row['postdate'];


    echo " <div class=\"col s4  \">
            <div class=\"card blue 1 white-text z-depth-5 medium postcard\" >
                <div class=\"card-image\">
                    <img src=\"$imgurl\" style=\"width: 300px;height: 300px\" class=\"materialboxed\">
                     $top
                    <span class=\"pusertext  \">
                </div>
                <div class=\"card-content\">
                    <div class=\"   col s12  \" style=\"text-transform: uppercase;\"><i class=\"material-icons left\">clear_all</i><b>$cat</b></div>
                    <p class=\"text-darken-4 \" style=\"  margin: 5px; \"> $disc
                    </p>
                </div>
               $link
            </div>
        </div>";


}

//function to retrive search post
function get_search_post($id, $type)
{
       global $conn;
    if ($type == "lost") {
        $sql = "SELECT `id`,`discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft` FROM `lthings` WHERE `id`=$id";

    } else {
        $sql = "SELECT `id`,`discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft` FROM `fthings` WHERE `id`=$id";
    }

    $retval=mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);
    if ($row['draft'] == 1) {
        return;
    }

    $id=$row['id'];
    $cat = get_catname($row['cat_ref']);
    $disc = $row['discription'];
    // $add=$row['adressid'];
    //$pincode=$row['pincode'];
    $user = get_user($row['uemail']);
    //$imgurl = get_imgurl($row['imgid'], $type);
    $pdate = $row['postdate'];

    echo "<tr>
        <td>$id</td>
        <td>$user</td>
        <td>$cat</td>
        <td>$disc</td>
        <td>$pdate</td>
        <td><a class=\"btn\" href='knowmore.php?id=$id&&type=$type'>know more</a> </td>
        </tr>";

}

//move a post to draft
function mov_draf($id, $type)
{

    global $conn;
    $date = date("Y-m-d");
    if ($type == "lost") {
        $sql = "UPDATE `lthings` SET  `draft`=1,`ddate`='$date' WHERE `id`=$id";
    } else {
        $sql = "UPDATE `fthings` SET  `draft`=1,`ddate`='$date' WHERE `id`=$id";
    }
    mysqli_query($conn, $sql);
    mysqli_commit($conn);
}

//function to get phone no
function get_phone($id)
{
    global $conn;
    $sql = "SELECT   `city`, `state`, `mobile` FROM `adress` WHERE aid=$id";
    $row = mysqli_fetch_array(mysqli_query($conn, $sql));
    return $row['mobile'];

}

//function to get full adress
function get_full_add($id)
{
    global $conn;
    $sql = "SELECT   `city`, `state`, `mobile` FROM `adress` WHERE aid=$id";
    $row = mysqli_fetch_array(mysqli_query($conn, $sql));
    return $row['city'] . "-" . $row['state'];

}

//function to authnticate admin
function auth_admin()
{
    global $conn;
    if (isset($_SESSION['login_user'])) {
        $x = $_SESSION['login_user'];
        $sql = "SELECT `isadmin` FROM `user` WHERE `email`='$x'";

        $row = mysqli_fetch_array(mysqli_query($conn, $sql));
        if ($row['isadmin'] != 1) {
            header("location:index.php");
        }
    } else {
        header('location:login.php');
    }
}

//function to get user list-admin-panel
function get_user_list()
{
    global $conn;
    $sql = "SELECT `email`,`isadmin`, `posts`,`isadmin` FROM `user` ";

    $retval = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $email = $row['email'];
        $user = get_user($email);
        $post = $row['posts'];

        echo "<tr><td>$user</td>
                <td>$email</td>
                <td>$post</td>
                <td><a href='deleteuser.php?id=$email' class='btn text-danger'>Delete</a></td>
                </tr>";

    }


}

//function to get post list-admin-panel 
function get_post_list($type)
{
    global $conn;
    if ($type == "lost") {
        $sql = "SELECT `id`, `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft` FROM `lthings` ";
        $top = " <span class=\"losttitle  z-depth-1 \"><b>LOST</b></span>";
    } else {
        $sql = "SELECT `id`,`discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft`  FROM `fthings`";
        $top = "<span class=\"foundtitle  z-depth-1 \"><b>FOUND</b></span>";
    }
    $retval = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {

         if ($row['draft'] == 1) {
             continue;
         }

        $cat = get_catname($row['cat_ref']);
        $id = $row['id'];
        // $add=$row['adressid'];
        //$pincode=$row['pincode'];
        $user = get_user($row['uemail']);
        //$imgurl = get_imgurl($row['imgid'], $type);
        $pdate = $row['postdate'];


        echo "<tr>
                <td>$id</td>
                <td>$user</td>
                <td>$cat</td>
                 <td>$pdate</td>
                <td><a href='knowmore.php?id=$id&&type=$type' class='btn text-success'>Details</a></td>
                </tr>";


    }
}

// Function to get post list for lost items as Bootstrap cards
// function get_lost_item_cards() {
//     global $conn;
//     $output = '';

//     $sql = "SELECT `id`, `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft` FROM `lthings` WHERE `draft` = 0";
//     $retval = mysqli_query($conn, $sql);

//     while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
//         $cat = get_catname($row['cat_ref']);
//         $id = $row['id'];
//         $user = get_user($row['uemail']);
//         $pdate = $row['postdate'];

//         // Get image URL
//         $imgurl = get_imgurl($row['imgid'], 'lost');

//         // Construct Bootstrap card
//         $output .= "<div class='col-md-4 mb-4'>
//                         <div class='card'>
//                             <img src='$imgurl' class='card-img-top' alt='Lost Item Image'>
//                             <div class='card-body'>
//                                 <h5 class='card-title'>$cat</h5>
//                                 <p class='card-text'>$pdate</p>
//                                 <a href='knowmore.php?id=$id&type=lost' class='btn btn-primary'>View Details</a>
//                             </div>
//                         </div>
//                     </div>";
//     }

//     return $output;
// }

//     $retval = mysqli_query($conn, $sql);

//     // Fetch and display results
//     while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
//         $cat = get_catname($row['cat_ref']);
//         $id = $row['id'];
//         $user = get_user($row['uemail']);
//         $pdate = $row['postdate'];

//         // Get image URL
//         $imgurl = get_imgurl($row['imgid'], 'lost');

//         // Construct Bootstrap card
//         $output .= "<div class='col-md-4 mb-4'>
//                         <div class='card'>
//                             <img src='$imgurl' class='card-img-top' alt='Lost Item Image'>
//                             <div class='card-body'>
//                                 <h5 class='card-title'>$cat</h5>
//                                 <p class='card-text'>$pdate</p>
//                                 <a href='knowmore.php?id=$id&type=lost' class='btn btn-primary'>View Details</a>
//                             </div>
//                         </div>
//                     </div>";
//     }

//     return $output;
// }
function get_lost_item_cards($keyword = '', $category = '', $date = '', $location = '') {
    global $conn;
    $output = '';

    // Base SQL query
    $sql = "SELECT `id`, `discription`, `cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`, `draft` 
            FROM `lthings` 
            WHERE `draft` = 0";

    // Add search filters
    if ($keyword) {
        $sql .= " AND (`discription` LIKE '%" . mysqli_real_escape_string($conn, $keyword) . "%')";
    }
    if ($category) {
        $sql .= " AND `cat_ref` = '" . mysqli_real_escape_string($conn, $category) . "'";
    }
    if ($date) {
        $sql .= " AND DATE(`postdate`) = '" . mysqli_real_escape_string($conn, $date) . "'";
    }
    if ($location) {
        $sql .= " AND `adressid` LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
    }

    $retval = mysqli_query($conn, $sql);

    // Fetch and display results
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $cat = get_catname($row['cat_ref']);
        $id = $row['id'];
        $user = get_user($row['uemail']);
        $pdate = $row['postdate'];

        // Get image URL
        $imgurl = get_imgurl($row['imgid'], 'lost');

        // Construct Bootstrap card
        $output .= "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <img src='$imgurl' class='card-img-top' alt='Lost Item Image'>
                            <div class='card-body'>
                                <h5 class='card-title'>$cat</h5>
                                <p class='card-text'>$pdate</p>
                                <a href='knowmore.php?id=$id&type=lost' class='btn btn-primary'>View Details</a>
                            </div>
                        </div>
                    </div>";
    }

    return $output;
}




// Function to get post list for found items as Bootstrap cards
// function get_found_item_cards() {
//     global $conn;
//     $output = '';

//     $sql = "SELECT `id`, `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft` FROM `fthings` WHERE `draft` = 0";
//     $retval = mysqli_query($conn, $sql);

//     while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
//         $cat = get_catname($row['cat_ref']);
//         $id = $row['id'];
//         $user = get_user($row['uemail']);
//         $pdate = $row['postdate'];

//         // Get image URL
//         $imgurl = get_imgurl($row['imgid'], 'found');

//         // Check if image URL is empty
//         if (empty($imgurl)) {
//             // If no image, display a default image or placeholder text
//             $imgurl = 'path_to_default_image/default_image.jpg'; // Set the path to your default image
//             // Or use placeholder text
//             // $imgurl = 'No Image Available';
//         }

//         // Construct Bootstrap card
//         $output .= "<div class='col-md-4 mb-4'>
//                         <div class='card'>
//                             <img src='$imgurl' class='card-img-top' alt='Found Item Image'>
//                             <div class='card-body'>
//                                 <h5 class='card-title'>$cat</h5>
//                                 <p class='card-text'>$pdate</p>
//                                 <a href='knowmore.php?id=$id&type=found' class='btn btn-primary'>View Details</a>
//                             </div>
//                         </div>
//                     </div>";
//     }

//     return $output;
// }
function get_found_item_cards($keyword = '', $category = '', $date = '', $location = '') {
    global $conn;
    $output = '';

    // Base SQL query
    $sql = "SELECT `id`, `discription`, `cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`, `draft` 
            FROM `fthings` 
            WHERE `draft` = 0";

    // Add search filters
    if ($keyword) {
        $sql .= " AND (`discription` LIKE '%" . mysqli_real_escape_string($conn, $keyword) . "%')";
    }
    if ($category) {
        $sql .= " AND `cat_ref` = '" . mysqli_real_escape_string($conn, $category) . "'";
    }
    if ($date) {
        $sql .= " AND DATE(`postdate`) = '" . mysqli_real_escape_string($conn, $date) . "'";
    }
    if ($location) {
        $sql .= " AND `adressid` LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
    }

    $retval = mysqli_query($conn, $sql);

    // Fetch and display results
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $cat = get_catname($row['cat_ref']);
        $id = $row['id'];
        $user = get_user($row['uemail']);
        $pdate = $row['postdate'];

        // Get image URL
        $imgurl = get_imgurl($row['imgid'], 'found');

        // Construct Bootstrap card
        $output .= "<div class='col-md-4 mb-4'>
                        <div class='card'>
                            <img src='$imgurl' class='card-img-top' alt='Found Item Image'>
                            <div class='card-body'>
                                <h5 class='card-title'>$cat</h5>
                                <p class='card-text'>$pdate</p>
                                <a href='knowmore.php?id=$id&type=found' class='btn btn-primary'>View Details</a>
                            </div>
                        </div>
                    </div>";
    }

    return $output;
}



//function to get post which are drafted
function get_draft_post()
{
    global $conn;
    $sqla = "SELECT `id`, `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft`,`ddate` FROM `lthings` ";
    $sqlb = "SELECT `id`,`discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft`,`ddate` FROM `fthings`";

    $retval = mysqli_query($conn, $sqla);
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {

        if ($row['draft'] == 1) {
            $cat = get_catname($row['cat_ref']);
            $id = $row['id'];
            // $add=$row['adressid'];
            //$pincode=$row['pincode'];
            $user = get_user($row['uemail']);
            //$imgurl = get_imgurl($row['imgid'], $type);
            $pdate = $row['postdate'];
            $ddate = $row['ddate'];

            echo "<tr>
                <td>$id</td>
                <td>$user</td>
                <td>lost</td>
                <td>$cat</td>
                 <td>$pdate</td>
                 <td>$ddate</td>
                <td><a href='knowmore.php?id=$id&&type=lost' class='btn text-white'>details</a></td>
                </tr>";
        }
    }

    $retval = mysqli_query($conn, $sqlb);
    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {

        if ($row['draft'] == 1) {
            $cat = get_catname($row['cat_ref']);
            $id = $row['id'];
            // $add=$row['adressid'];
            //$pincode=$row['pincode'];
            $user = get_user($row['uemail']);
            //$imgurl = get_imgurl($row['imgid'], $type);
            $pdate = $row['postdate'];
            $ddate = $row['ddate'];

            echo "<tr>
                <td>$id</td>
                <td>$user</td>
                <td>found</td>
                <td>$cat</td>
                 <td>$pdate</td>
                 <td>$ddate</td>
                <td><a href='knowmore.php?id=$id&&type=found' class='btn'>details</a></td>
                </tr>";
        }
    }
}

//function retruns true if user is admin
function is_admin()
{
    global $conn;
    if (isset($_SESSION['login_user'])) {
        $x = $_SESSION['login_user'];
        $sql = "SELECT `isadmin` FROM `user` WHERE `email`='$x'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($row && isset($row['isadmin']) && $row['isadmin'] == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}



//function to get total count of table
function t_count($x){
    global $conn;
    $sql="SELECT COUNT(*) total FROM `$x`";
    $retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);
    return $row['total'];

}

//function to get total count of table
function tp_count($x){
    global $conn;
    $sql="SELECT COUNT(*) total FROM `$x` WHERE `draft`=0 ";

    $retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);
    return $row['total'];

}

//function to get total count of draft post
function draft_post_count(){
    global $conn;
    $sql="SELECT COUNT(`id`) 'total' FROM `fthings` WHERE draft=1";
    $retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);
    $total=$row['total'];

    $sql="SELECT COUNT(`id`) 'total' FROM `lthings` WHERE draft=1";
    $retval = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($retval);

    $total=$total+$row['total'];
    return $total;
}


function pending_account_count() {
    global $conn;

    $sql = "SELECT COUNT(*) AS pending_count FROM user WHERE is_active = 0";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['pending_count'];
    } else {
        return 0; // Return 0 if the query fails
    }
}

?>