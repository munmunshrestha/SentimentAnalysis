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

?>
<script type="text/javascript">
    function checkCaptcha() {
        // var ch = document.getElementsByName("feedback[]");
      
            //checking if recaptcha is checked
            var response = grecaptcha.getResponse();
            //response.length=0 if not checked
            if (response.length == 0) {
                alert("The form is not completely filled.");
                return false;
            } else {
                return true;
                //when it return true- your form will  submit and will  redirect
            }

        // }
    }
</script>
<?php
if (isset($_POST["submit"])) {

    // if ($_POST["g-recaptcha-response"]) {
    //     $response = $reCaptcha->verifyResponse(
    //         $_SERVER["REMOTE_ADDR"],
    //         $_POST["g-recaptcha-response"]
    //     );
    // }

    // if ((isset($_POST["feedback"]) && count($_POST["feedback"]) != 0) && ($response != null && $response->success)) {
    if (isset($_POST["feedback"]) ) {
        $feedback_array = $_POST['feedback'];
        $count=0;     
        foreach ($feedback_array as $feedback_text) {
            if ($feedback_text != "") {
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
            else{
                $count++;
            }
        }
        if ($count==count($feedback_array)){
            $_SESSION["message"] = "You must enter a feedback to submit";
        }
    } 
    


    redirect("feedbackForm.php");
} else {
    ?>
    <div class="container">
        <h2> Feedback Form</h2>

        <h5> Your feedback is anonymous so feel free to write about anything related to our Computer Science Department. </h5>
        <h5> You can provide both positive feedback and constructive criticism to the department. Please keep each feedback specific to one topic and <b> please be professional.</b></h5>
        <iframe name="votar" style="display:none;"></iframe>
        <form method="POST" name="form" action="feedbackForm.php" id="my_captcha_form" onsubmit="return checkCaptcha()">
            <div class="field_wrapper">
                <div class="col-md-4"><label for="comment">Enter your feedback below:</label></div>
                <div class="col-md-4 col-md-offset-4"><a href="javascript:void(0);" class="add_button pull-right" title="Add field"><img src="add.ico" width="18" height="18">
Add Another Feedback</a></div>
                <textarea class="form-control" rows="5" id="feedbackid" name="feedback[]"></textarea>
                <p></p>
                <?php add_textField(); ?>
            </div>

            <p>
                <div class="g-recaptcha" data-sitekey="6Le2L7gUAAAAAGP7U9D40nU-kN0xbQRdUK9aWdOk"></div>
            </p>
            <p><button type="submit" class="btn btn-default" name="submit">Submit</button></p>

        </form>
    </div>

<?php
}

function add_textField()
{
    ?>
    <script>
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = "<div><textarea class='form-control' rows='5' id='feedbackid' name='feedback[]'></textarea><a href='javascript:void(0);' class='remove_button pull-right'><img src='delete.jpeg' width='18' height='18'>Delete</a></div>"; //New input field html 
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
<?php  }

new_footer();
$stmt = NULL;
Database::dbDisconnect();
?>