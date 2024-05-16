<?php
/**
* Plugin Name: slate-spin-to-win-plugin
* Plugin URI: https://www.slatepickelballclub.com/
* Description: A spin to win wheel to earn discounted items at Slate Pickelball Club.
* Version: 0.1
* Author: Slate Pickelball
* Author URI: https://www.slatepickelballclub.com/
**/

?>

<script>
const sections = [
    { label: "Free Lesson", color: "#FF6347" },
    { label: "50% Off Membership for One Month", color: "#6495ED" },
    { label: "Free Drink", color: "#32CD32" },
    { label: "Free 1 Hour Court Reservation", color: "#FF8C00" },
    { label: "Free Cardio Pickleball Class", color: "#9370DB" },
    { label: "Free Guest Pass", color: "#20B2AA" }
];

function spin() {
    const animationDuration = 3000; // in milliseconds
    const startAngle = 0;
    const endAngle = Math.random() * 360 * 10; // 10 rotations
    const startTime = performance.now();

    if (nameInput.value === '' || emailInput.value === '') {
        
        alert("You must enter your name and email address to spin the wheel.");
        return; // Exit function if input fields are empty
    }

    function animate(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / animationDuration, 1);
        const angle = startAngle - (startAngle - endAngle) * progress;
        wheel.style.transform = `rotate(${angle}deg)`;

        // If animation isn't done, recursively call the function
        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            // Calculate the final angle after the animation completes (between 0 - 360)
            const numSections = sections.length;
            let finalAngle = 360 - (angle % 360);
            // Calculate the section index based on the final angle
            const anglePerSection = 360 / numSections;
            let sectionIndex = Math.floor(finalAngle / anglePerSection);

            let landedOnLabel = "????";
            // Determine the section label based on the final angle
            if (finalAngle >= 332 && finalAngle <= 30) {
                landedOnLabel = "50% Off Membership for One Month"
            } else if (finalAngle > 30 && finalAngle <= 90) {
                landedOnLabel = "Free Drink";
            } else if (finalAngle > 90 && finalAngle <= 148) {
                landedOnLabel = "Free 1 Hour Court Reservation";
            } else if (finalAngle > 148 && finalAngle <= 210) {
                landedOnLabel = "Free Cardio Pickelball Class";
            } else if (finalAngle > 210 && finalAngle <= 270) {
                landedOnLabel = "Free Guest Pass";
            } else {
                landedOnLabel = "Free Lesson";
            }
            // Update the #landed-on element with the correct value
            landedOn.textContent = "Congrats! You have won a " + landedOnLabel;
            sendResults();
        }
    }

    requestAnimationFrame(animate);
}

function sendResults() {
   const req = new XMLHttpRequest();
   req.open("POST", "/", true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   dataz = "userEmail=" + emailInput.value + "&userName=" + nameInput.value + "&prizeWon=" + landedOn.textContent
   alert(dataz)
   req.send(dataz);
}

</script>
