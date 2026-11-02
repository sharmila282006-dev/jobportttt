<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Applications</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="myapplications-page">

    <header>

        <h1>💼 Job Portal System</h1>

        <nav>
            <a href="profile.html">Profile</a>
            <a href="contact.html">Contact</a>
            <a href="logout.php">Logout</a>
        </nav>

    </header>


    <section class="applications-section">

        <h2>📋 My Applications</h2>

        <p class="applications-subtitle">
            Track your job applications and application details.
        </p>

        <div id="applicationsContainer">

            <p>Loading applications...</p>

        </div>


        <div class="application-buttons">

            <a href="jobs.html">
                <button>🔍 Browse More Jobs</button>
            </a>

            <button onclick="window.location.href='logout.php'">
    🚪 Logout
</button>

        </div>

    </section>


    <script src="js/script.js"></script>


    <script>

        function loadApplications() {

            fetch("get_applications.php")

                .then(response => response.json())

                .then(applications => {

                    const container =
                        document.getElementById("applicationsContainer");

                    container.innerHTML = "";


                    if (applications.length === 0) {

                        container.innerHTML =
                            "<p>📭 No applications found.</p>";

                        return;

                    }


                    applications.forEach(application => {

                        const card =
                            document.createElement("div");

                        card.className =
                            "application-card";


                        card.innerHTML = `

                            <h3>💼 ${application.title}</h3>

                            <p>
                                <b>🏢 Company:</b>
                                ${application.company}
                            </p>

                            <p>
                                <b>📍 Location:</b>
                                ${application.location}
                            </p>

                            <p>
                                <b>👤 Name:</b>
                                ${application.name}
                            </p>

                            <p>
                                <b>📧 Email:</b>
                                ${application.email}
                            </p>

                            <p>
                                <b>📱 Phone:</b>
                                ${application.phone}
                            </p>

                            <p>
                                <b>📄 Resume:</b>
                                ${application.resume || "Not uploaded"}
                            </p>

                            <p>
                                <b>📅 Applied On:</b>
                                ${application.applied_at}
                            </p>

                            <p>
                                <b>📌 Status:</b>
                                ${application.status}
                            </p>

                        `;


                        container.appendChild(card);

                    });

                })


                .catch(error => {

                    console.log("Error:", error);

                    document.getElementById(
                        "applicationsContainer"
                    ).innerHTML =
                        "<p>❌ Unable to load applications.</p>";

                });

        }


        loadApplications();

    </script>


    <footer>

        <p>© 2026 Job Portal | All Rights Reserved</p>

    </footer>

</body>

</html>