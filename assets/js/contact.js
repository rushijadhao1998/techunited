document.addEventListener("DOMContentLoaded", function () {

    emailjs.init("_TW7vXq-ETDs-_rUY");

    document.getElementById("contact").addEventListener("submit", function (e) {
        e.preventDefault();

        const btn = document.getElementById("form-submit");
        btn.innerText = "Sending...";
        btn.disabled = true;

        const params = {
            from_name: document.getElementById("name").value,
            from_email: document.getElementById("email").value,
            phone: document.getElementById("phone").value,
            message: document.getElementById("message").value,
            reply_to: document.getElementById("email").value
        };

        // Admin Mail
        emailjs.send("service_6rokkm3", "template_5x06x0b", params)

        // Auto Reply
        .then(() => emailjs.send("service_6rokkm3", "template_mun3ye9", params))

        .then(() => {
            alert("Message sent successfully!");
            document.getElementById("contact").reset();
        })
        .catch((error) => {
            console.log("ERROR:", error);
            alert("Failed to send message");
        })
        .finally(() => {
            btn.innerText = "Send Message";
            btn.disabled = false;
        });

    });

});