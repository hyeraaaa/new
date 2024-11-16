document.addEventListener("DOMContentLoaded", function () {
    const cardBodies = document.querySelectorAll(".card-body p:not(.card-text)");
    cardBodies.forEach(body => {
        const fullText = body.textContent.trim();
        const words = fullText.split(" ");

        if (words.length > 15) {
            const truncatedText = words.slice(0, 15).join(" ") + "... ";
            const seeMoreLink = document.createElement("a");
            seeMoreLink.href = "#";
            seeMoreLink.textContent = "See more";
            seeMoreLink.style.textDecoration = "none";
            seeMoreLink.style.color = "black";

            body.textContent = truncatedText;
            body.appendChild(seeMoreLink);

            let isExpanded = false;

            seeMoreLink.addEventListener("click", function (event) {
                event.preventDefault();
                if (!isExpanded) {
                    body.textContent = fullText;

                    // Create the "See Less" link
                    const seeLessLink = document.createElement("a");
                    seeLessLink.href = "#";
                    seeLessLink.textContent = " ...See less";
                    seeLessLink.style.textDecoration = "none";
                    seeLessLink.style.color = "black";

                    body.appendChild(seeLessLink);

                    // Update the flag
                    isExpanded = true;

                    seeLessLink.addEventListener("click", function (event) {
                        event.preventDefault();
                        body.textContent = truncatedText; // Collapse back to truncated text
                        body.appendChild(seeMoreLink); // Re-add "See more" link

                        // Reset the flag
                        isExpanded = false;
                    });
                }
            });
        }
    });
});