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
            message: document.getElementById("message").value
        };

        // Send message to Admin
        emailjs.send("service_6rokkm3", "template_5x06x0b", {
            ...params,
            to_email: "info@unitedtech.in"
        })

            // Send auto-reply to User
            .then(() => {
                return emailjs.send(
                    "service_6rokkm3",      // <-- service id
                    "template_mun3ye9",   // <-- auto-reply template id
                    params
                );
            })

            .then(() => {
                alert("Message sent successfully!");
                document.getElementById("contact").reset();
            })

            .catch((error) => {
                console.log(error);
                alert("Failed to send message.");
            })

            .finally(() => {
                btn.innerText = "Send Message";
                btn.disabled = false;
            });

    });

});