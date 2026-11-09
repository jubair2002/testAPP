
pipeline {
    agent any

    environment {
        DEPLOY_HOST = 'ubuntu@172.31.25.199'
        APP_DIR = '/home/ubuntu/testAPP'
    }

    options {
        timestamps()
        disableConcurrentBuilds()
        timeout(time: 20, unit: 'MINUTES')
    }

    stages {

        // Stage 1: Check server connectivity and environment
        stage('Pre-deployment Checks') {
            steps {
                sshagent(['jenkins-deploy-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ${DEPLOY_HOST} '
                            set -e

                            echo "Checking Laravel server..."

                            cd /home/ubuntu/testAPP

                            test -f artisan
                            test "$(git branch --show-current)" = "main"

                            php --version
                            composer --version

                            systemctl is-active --quiet apache2
                            systemctl is-active --quiet php8.4-fpm

                            echo "Pre-deployment checks passed!"
                        '
                    '''
                }
            }
        }

        // Stage 2: Pull latest code
        stage('Deploy Code') {
            steps {
                sshagent(['jenkins-deploy-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ${DEPLOY_HOST} '
                            set -e

                            cd /home/ubuntu/testAPP

                            echo "Pulling latest code..."

                            git pull --ff-only origin main

                            echo "Current deployed commit:"
                            git rev-parse --short HEAD
                        '
                    '''
                }
            }
        }

        // Stage 3: Install PHP dependencies
        stage('Install Dependencies') {
            steps {
                sshagent(['jenkins-deploy-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ${DEPLOY_HOST} '
                            set -e

                            cd /home/ubuntu/testAPP

                            echo "Installing Composer dependencies..."

                            composer install \
                                --no-dev \
                                --prefer-dist \
                                --optimize-autoloader \
                                --no-interaction

                            echo "Dependencies installed!"
                        '
                    '''
                }
            }
        }

        // Stage 4: Clear and rebuild Laravel cache
        stage('Laravel Cache') {
            steps {
                sshagent(['jenkins-deploy-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ${DEPLOY_HOST} '
                            set -e

                            cd /home/ubuntu/testAPP

                            echo "Clearing Laravel cache..."

                            php artisan optimize:clear

                            echo "Rebuilding configuration cache..."

                            php artisan config:cache

                            echo "Laravel cache completed!"
                        '
                    '''
                }
            }
        }

        // Stage 5: Verify application
        stage('Health Check') {
            steps {
                sshagent(['jenkins-deploy-key']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ${DEPLOY_HOST} '
                            set -e

                            echo "Checking Apache..."
                            systemctl is-active apache2

                            echo "Checking PHP-FPM..."
                            systemctl is-active php8.4-fpm

                            echo "Checking Laravel HTTP response..."

                            HTTP_CODE=$(curl -sS -o /dev/null \
                                -w "%{http_code}" http://127.0.0.1/)

                            echo "HTTP Status: $HTTP_CODE"

                            case "$HTTP_CODE" in
                                2??|3??)
                                    echo "Laravel application is healthy!"
                                    ;;
                                *)
                                    echo "Laravel health check failed!"
                                    exit 1
                                    ;;
                            esac
                        '
                    '''
                }
            }
        }
    }

    post {
        success {
            echo 'SUCCESS: Laravel deployment completed!'
        }

        failure {
            echo 'FAILED: Laravel deployment failed. Check the stage logs.'
        }
    }
}
