<?php
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");
require_once("reCaptcha.php");

$secret = "6Le2L7gUAAAAAGi-it4JuQl81NE4EGYK9WMz4FTA";
$response = null;
$reCaptcha = new ReCaptcha($secret);

new_header("FeedbackForm");
$mysqli = Database::dbConnect();
$mysqli->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

if (isset($_POST["submit"])) {

    if ($_POST["g-recaptcha-response"]) {
        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }

    if ((isset($_POST["feedback"]) && count($_POST["feedback"]) != 0) && ($response != null && $response->success)) {
        $feedback_array= $_POST['feedback'];
         echo count($_POST["feedback"]);      
        foreach($feedback_array as $feedback_text){
            if ($feedback_text!=""){
                //Create and prepare query to insert information that has been posted
                $query = "INSERT INTO HP_FEEDBACK (FEEDBACK_TEXT) VALUES (?)";
                // Execute query
                $stmt = $mysqli->prepare($query);
                $stmt->execute([$feedback_text]);
                if ($stmt) {
                    $_SESSION["message"] = "Thankyou for your feedback!";
                } else {
                    $_SESSION["message"] = "ERROR! Could not submit feedback";
                }
            }
        }
    } else {
        $_SESSION["message"] = "The form is not completely filled";
    }


    // redirect("feedbackForm.php");
} else {
    ?>
    <div class="container">
        <h2> Feedback Form</h2>

        <h5> Your feedback is anonymous so feel free to write about anything related to our Computer Science Department. </h5>
        <h5> You can provide both positive feedback and constructive criticism to the department. <b> Please be professional.</b></h5>
        <form method="POST" action="feedbackForm.php" id="my_captcha_form">
            <div class="field_wrapper">
                <div><label for="comment">Enter your feedback below:</label></div>
                    
                <textarea class="form-control" rows="5" id="comment" name="feedback[]"></textarea>
                <?php add_textField(); ?>
                <a href="javascript:void(0);" class="add_button pull-right" title="Add field">Add Another Feedback</a>
            </div>
   
            <p>
                <div class="g-recaptcha" data-sitekey="6Le2L7gUAAAAAGP7U9D40nU-kN0xbQRdUK9aWdOk"></div>
            </p>
            <p></p>

            <button type="submit" class="btn btn-default" name="submit">Submit</button>
            
        </form>
    </div>
<?php
}
new_footer();
$stmt = NULL;
Database::dbDisconnect();
?>