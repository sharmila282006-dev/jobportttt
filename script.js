

function applyJob(jobName) {

    localStorage.setItem("selectedJob", jobName);

    window.location.href = "apply.html";
}

function logout() {
    localStorage.removeItem("loggedInUser");
    alert("Logged out successfully!");
    window.location.href = "login.html";
}

function showProfile() {

    let name = localStorage.getItem("name");
    let email = localStorage.getItem("email");
    let phone = localStorage.getItem("phone");

    document.getElementById("profileName").innerText =
        name || "Job Seeker";

    document.getElementById("profileEmail").innerText =
        email || "Email not available";

    document.getElementById("emailDetails").innerText =
        email || "Not available";

    document.getElementById("phoneDetails").innerText =
        phone || "Not available";
}

function showAdminDashboard() {

    // Total Jobs
    fetch("get_job_count.php")
        .then(response => response.text())
        .then(count => {
            let jobsBox = document.getElementById("totalJobs");

            if (jobsBox) {
                jobsBox.innerText = count.trim();
            }
        })
        .catch(error => {
            console.log("Job count error:", error);
        });


    // Total Applications
    fetch("get_application_count.php")
        .then(response => response.text())
        .then(count => {
            let applicationsBox =
                document.getElementById("totalApplications");

            if (applicationsBox) {
                applicationsBox.innerText = count.trim();
            }
        })
        .catch(error => {
            console.log("Application count error:", error);
        });


    // Saved Jobs
    let savedJobs =
        JSON.parse(localStorage.getItem("savedJobs")) || [];

    let savedBox =
        document.getElementById("totalSavedJobs");

    if (savedBox) {
        savedBox.innerText = savedJobs.length;
    }


    // Notifications
    let notification =
        localStorage.getItem("notification");

    let notificationBox =
        document.getElementById("notificationStatus");

    if (notificationBox) {
        notificationBox.innerText =
            notification ? "1" : "0";
    }


    // Job Alerts
    let jobAlerts =
        localStorage.getItem("jobAlerts");

    let jobAlertBox =
        document.getElementById("jobAlertStatus");

    if (jobAlertBox) {
        jobAlertBox.innerText =
            jobAlerts === "enabled" ? "1" : "0";
    }


    // Recent Application
    fetch("get_admin_application.php")
        .then(response => response.json())
        .then(application => {

            let adminApplication =
                document.getElementById("adminApplication");

            if (!adminApplication) {
                return;
            }

            if (application.length === 0) {
                adminApplication.innerHTML =
                    "No applications available.";
                return;
            }

            let statusIcon = "🟡";

            if (application.status === "Shortlisted") {
                statusIcon = "🟢";
            } 
            else if (application.status === "Rejected") {
                statusIcon = "🔴";
            }

            adminApplication.innerHTML =
                "💼 <b>Job:</b> " + application.title +
                "<br>🏢 <b>Company:</b> " + application.company +
                "<br>👤 <b>Name:</b> " + application.name +
                "<br>📧 <b>Email:</b> " + application.email +
                "<br>📱 <b>Phone:</b> " + application.phone +
                "<br>" + statusIcon +
                " <b>Status:</b> " + application.status;
        })
        .catch(error => {
            console.log("Application error:", error);
        });
}

function viewAdminApplication() {

    fetch("get_admin_application.php")
        .then(response => response.json())
        .then(application => {

            if (application.length === 0) {
                alert("No application available.");
                return;
            }

            alert(
                "📋 FULL APPLICATION DETAILS\n\n" +
                "💼 Job: " + application.title + "\n" +
                "🏢 Company: " + application.company + "\n" +
                "📍 Location: " + application.location + "\n" +
                "👤 Name: " + application.name + "\n" +
                "📧 Email: " + application.email + "\n" +
                "📱 Phone: " + application.phone + "\n" +
                "📄 Resume: " + (application.resume || "Not uploaded") + "\n" +
                "📌 Status: " + application.status
            );

        })
        .catch(error => {
            console.log("Application error:", error);
            alert("Unable to load application.");
        });
}

function showAddJobForm() {

    let form = document.getElementById("addJobForm");

    form.innerHTML = `
        <div class="add-job-form">

            <h3>➕ Add New Job</h3>

            <input type="text" id="newJobName" placeholder="Job Title">

            <input type="text" id="newCompany" placeholder="Company">

            <input type="text" id="newLocation" placeholder="Location">

            <input type="text" id="newSalary" placeholder="Salary">

            <input type="text" id="newExperience" placeholder="Experience">

            <br><br>

            <button onclick="addNewJob()">
                ✅ Add Job
            </button>

        </div>
    `;
}
function addNewJob() {

    let jobName = document.getElementById("newJobName").value;
    let company = document.getElementById("newCompany").value;
    let location = document.getElementById("newLocation").value;
    let salary = document.getElementById("newSalary").value;
    let experience = document.getElementById("newExperience").value;

    if (
        jobName === "" ||
        company === "" ||
        location === "" ||
        salary === "" ||
        experience === ""
    ) {
        alert("Please fill all job details!");
        return;
    }

    fetch("add_job.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "title=" + encodeURIComponent(jobName) +
            "&company=" + encodeURIComponent(company) +
            "&location=" + encodeURIComponent(location) +
            "&salary=" + encodeURIComponent(salary) +
            "&experience=" + encodeURIComponent(experience)
    })
    .then(response => response.text())
    .then(result => {

        alert(result);

        if (result.includes("successfully")) {
            document.getElementById("addJobForm").innerHTML = "";
            showAdminJobs();
        }

    })
    .catch(error => {
        console.log("Add Job Error:", error);
        alert("Unable to add job.");
    });
}

function showAdminJobs() {

    fetch("get_jobs.php")
        .then(response => response.json())
        .then(jobs => {

            let jobList = document.getElementById("adminJobList");

            if (!jobList) {
                return;
            }

            if (jobs.length === 0) {
                jobList.innerHTML = "<p>No jobs available.</p>";
                return;
            }

            jobList.innerHTML = "<h3>📋 Added Jobs</h3>";

            jobs.forEach(function(job) {

                jobList.innerHTML += `
                    <div class="admin-job-card">

                        <h3>💼 ${job.title}</h3>

                        <p>🏢 <b>Company:</b> ${job.company}</p>

                        <p>📍 <b>Location:</b> ${job.location}</p>

                        <p>💰 <b>Salary:</b> ${job.salary}</p>

                        <p>💼 <b>Experience:</b> ${job.experience}</p>

<button onclick="deleteJobFromDatabase(${job.id})">
    🗑️ Delete
</button>

                    </div>
                `;
            });

        })
        .catch(error => {
            console.log("Admin Jobs Error:", error);
        });
}

function deleteJobFromDatabase(jobId) {

    if (!confirm("Are you sure you want to delete this job?")) {
        return;
    }

    fetch("delete_job.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "job_id=" + encodeURIComponent(jobId)
    })
    .then(response => response.text())
    .then(result => {

        alert(result);

        if (result.includes("successfully")) {
            showAdminJobs();
        }

    })
    .catch(error => {
        console.log("Delete Job Error:", error);
        alert("Unable to delete job.");
    });
}
function clearAdminApplication() {

    let confirmClear = confirm(
        "Are you sure you want to clear the application?"
    );

    if (!confirmClear) {
        return;
    }

    fetch("delete_application.php")
        .then(response => response.text())
        .then(result => {

            if (result.includes("successfully")) {

                alert("Application cleared successfully! 🧹");

                showAdminDashboard();

            } else {

                alert(result);

            }

        })
        .catch(error => {

            console.log("Delete error:", error);

            alert("Unable to clear application.");

        });
}

function changeAdminStatus() {

    let newStatus = prompt(
        "Enter Status:\n\nUnder Review\nShortlisted\nRejected",
        "Under Review"
    );

    if (newStatus === null) {
        return;
    }

    if (
        newStatus !== "Under Review" &&
        newStatus !== "Shortlisted" &&
        newStatus !== "Rejected"
    ) {
        alert("Please enter a valid status!");
        return;
    }

    fetch("update_status.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "status=" + encodeURIComponent(newStatus)
    })
    .then(response => response.text())
    .then(result => {

        if (result.includes("successfully")) {
            alert("Application status updated successfully! 📌");
            showAdminDashboard();
        } else {
            alert(result);
        }

    })
    .catch(error => {
        console.log("Status error:", error);
        alert("Unable to update status.");
    });
}

function enableJobAlerts() {

    fetch("job_alert.php")
        .then(response => response.text())
        .then(result => {

            alert(result);

        })
        .catch(error => {

            console.log("Job Alert Error:", error);

            alert("Unable to update Job Alerts.");

        });
}