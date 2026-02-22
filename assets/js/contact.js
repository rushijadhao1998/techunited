document.addEventListener("DOMContentLoaded", function () {

            // INIT EMAILJS
            emailjs.init("_TW7vXq-ETDs-_rUY");   // from emailjs dashboard

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

                emailjs.send("service_6rokkm3", "template_5x06x0b", params)
                    .then(function () {
                        alert("Message sent successfully!");
                        document.getElementById("contact").reset();
                        btn.innerText = "Send Message";
                        btn.disabled = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                        alert("Failed to send message. Check console.");
                        btn.innerText = "Send Message";
                        btn.disabled = false;
                    });

            });

        });