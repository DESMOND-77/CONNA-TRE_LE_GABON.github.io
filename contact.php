<?php
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Adresse email invalide.";
    } else {
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nob692888@gmail.com';
            $mail->Password = 'vietcbwaqzxoahbp';
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->setFrom($email, $name);
            $mail->addAddress('guimapidesmond@gmail.com', 'Guimapi Desmond');
            $mail->addReplyTo($email, $name);
            $mail->Subject = "$subject";
            $mail->Body = "
                <p>Vous avez reçu un nouveau message de $name ($email):</p>
                <p><strong>Message :</strong><br>" . nl2br($message) . "</p>
            ";

            if ($mail->send()) {
                $success_message = "Message envoyé avec succès !";
            } else {
                $error_message = "Erreur lors de l'envoi du message : " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            $error_message = "Erreur lors de l'envoi du message : " . $mail->ErrorInfo;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous | Gabon explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="./assets/css/custom.css">
    <script src="./assets/js/custom.js"></script>
    <script src="./assets/js/tailwind.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #fdf2d8 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .contact-container {
            background: linear-gradient(160deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }

        .contact-header {
            background: linear-gradient(135deg, #48bb78 0%, #4299e1 100%);
            position: relative;
            overflow: hidden;
        }

        .contact-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
        }

        .contact-header h1 {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #48bb78;
            z-index: 10;
        }

        .form-control {
            padding-left: 45px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 50px;
        }

        .form-control:focus {
            border-color: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.2);
        }

        textarea.form-control {
            height: auto;
            padding-top: 12px;
            min-height: 150px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #f6e05e 0%, #48bb78 50%, #4299e1 100%);
            background-size: 200% auto;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.5s ease;
            height: 50px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .submit-btn:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .contact-decoration {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #f6e05e 0%, #48bb78 50%, #4299e1 100%);
            clip-path: polygon(100% 0, 0 100%, 100% 100%);
            border-radius: 0 0 20px 0;
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .contact-info {
            background: linear-gradient(135deg, #edf2f7 0%, #f7fafc 100%);
            border-radius: 12px;
            padding: 25px;
            position: relative;
        }

        .contact-info::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #f6e05e, #48bb78, #4299e1);
            border-radius: 4px 0 0 4px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .email-icon {
            background: linear-gradient(135deg, #f6e05e 0%, #f6ad55 100%);
        }

        .phone-icon {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }

        .location-icon {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        }

        .footer {
            background: linear-gradient(135deg, #48bb78 0%, #4299e1 100%);
            color: white;
            padding: 20px 0;
            margin-top: auto;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: white;
            color: #4299e1;
            transform: translateY(-5px);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(72, 187, 120, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(72, 187, 120, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(72, 187, 120, 0);
            }
        }
    </style>

</head>

<body>
    <!-- Barre de progression -->
    <div class="w-full h-1 bg-gray-200 fixed top-0 z-50">
        <div id="progressBar" class="h-1 bg-gradient-to-r from-accent-500 via-primary-500 to-secondary-500 w-0"></div>
    </div>
    <div class="flex-grow">
        <div class="md:ml-auto mt-4 md:mt-0 absolute top-0 left-0 p-4">
            <a href="index.php" class="bg-gabon-blue hover:bg-blue-800 text-white px-4 py-2 rounded-md transition flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Page d'accueil
            </a>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Contactez l'Équipe de Gabon Explorer</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Nous sommes là pour répondre à vos questions et écouter vos suggestions
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="contact-container">
                    <div class="contact-header py-8 px-8 text-center">
                        <h1 class="text-3xl font-bold text-white mb-2">Envoyez-nous un message</h1>
                        <p class="text-white opacity-90">Nous vous répondrons dans les plus brefs délais</p>
                    </div>

                    <div class="p-8">
                        <?php if ($success_message): ?>
                            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                <span><?php echo $success_message; ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($error_message): ?>
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                                <span><?php echo $error_message; ?></span>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-6">
                            <div class="form-group">
                                <i class="form-icon fas fa-user"></i>
                                <input type="text" id="name" name="name" required
                                    class="w-full form-control focus:outline-none focus:ring-0"
                                    placeholder="Votre nom complet">
                            </div>

                            <div class="form-group">
                                <i class="form-icon fas fa-envelope"></i>
                                <input type="email" id="email" name="email" required
                                    class="w-full form-control focus:outline-none focus:ring-0"
                                    placeholder="Votre adresse email">
                            </div>

                            <div class="form-group">
                                <i class="form-icon fas fa-tag"></i>
                                <input type="text" id="subject" name="subject" required
                                    class="w-full form-control focus:outline-none focus:ring-0"
                                    placeholder="Sujet de votre message">
                            </div>

                            <div class="form-group">
                                <i class="form-icon fas fa-comment-dots" style="top: 25px; transform: none;"></i>
                                <textarea id="message" name="message" rows="5" required
                                    class="w-full form-control focus:outline-none focus:ring-0"
                                    placeholder="Votre message..."></textarea>
                            </div>

                            <div>
                                <button type="submit" class="w-full submit-btn">
                                    <i class="fas fa-paper-plane mr-2"></i> Envoyer le message
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="contact-decoration"></div>
                </div>

                <div class="contact-info">
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Informations de contact</h2>
                        <p class="text-gray-600">
                            Vous pouvez également nous contacter directement via les informations ci-dessous
                        </p>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon email-icon">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Email</h3>
                            <p class="text-gray-600"><a class="underline" href="mailto:guimapidesmond@outlook.com">contact@gabonxplorer.ga</a></p>

                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon phone-icon">
                            <i class="fas fa-phone-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Téléphone</h3>
                            <p class="text-gray-600">+241 62 94 75 66</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon location-icon">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Adresse</h3>
                            <p class="text-gray-600">Potos, Franceville, Gabon</p>
                        </div>
                    </div>

                    <div class="mt-12">
                        <h3 class="font-bold text-gray-800 mb-4">Suivez-nous</h3>
                        <div class="social-links">
                            <a href="#" class="pulse"><i class="fab  fa-facebook-f"></i></a>
                            <a href="#" class="pulse"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="pulse"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="pulse"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Retour en haut -->
    <a href="#" class="flex backToTop fixed bottom-0 right-6 w-10 h-9 rounded-full bg-gradient-to-r from-primary-600 to-accent-600 hover:from-secondary-600 hover:to-accent-900 text-white  items-center justify-center shadow-lg hover:shadow-xl transition ease-linear z-50">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-primary-800 to-accent-800 text-white py-12 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Section à propos -->
            <div class="md:col-span-2">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full mr-4 bg-secondary-500 flex items-center justify-center">
                        <img src="./assets/images/logo.png" alt="Logo" class="w-8 h-8">
                    </div>
                    <div class="text-2xl font-bold">Gabon Explorer</div>
                </div>
                <p class="text-gray-300 mb-4">Une plateforme éducative pour découvrir l'histoire, la culture et les richesses du Gabon.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white hover:text-secondary-300"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>



            <!-- Contact -->
            <div>
                <h4 class="text-xl font-semibold mb-4 text-secondary-300">Contact</h4>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-3 text-secondary-300"></i>
                        <span><a class="underline" href="mailto:guimapidesmond@outlokk.com">contact@gabonexplorer.ga</a></span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone mt-1 mr-3 text-secondary-300"></i>
                        <span>+241 62 94 75 66</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-secondary-300"></i>
                        <span>Franceville, Gabon</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-10 pt-6 border-t border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; <?= date('Y') ?> Gabon Explorer. Tous droits réservés.</p>
                <p class="text-green-300 text-sm mt-2 md:mt-0">Découvrir, comprendre et préserver la richesse du Gabon</p>
            </div>
        </div>
    </footer>

    <script>
        // Animation pour le bouton d'envoi
        document.querySelector('.submit-btn').addEventListener('click', function() {
            this.classList.add('animate-pulse');
            setTimeout(() => {
                this.classList.remove('animate-pulse');
            }, 1000);
        });
    </script>
</body>

</html>