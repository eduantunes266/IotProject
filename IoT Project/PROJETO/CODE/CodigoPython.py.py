import requests

import RPi.GPIO as GPIO

from time import sleep, strftime, localtime

from datetime import datetime

import cv2 







webcam_url="http://10.20.229.104:4747/video"

# ==============================

# Configuração de pinos GPIO

# ==============================

# Sensor LDR (Dia/Noite)

LDR_PIN       = 18

# LED para temperatura

TEMP_LED_PIN  = 23

# LEDs das bandeiras

PIN_VERMELHO  = 17

PIN_VERDE     = 27

PIN_AMARELO   = 22

# Buzzer de 3 pinos (VCC, GND e SINAL) → usar um GPIO livre, ex. BCM 24

BUZZER_PIN    = 24



# Modo BCM e desliga avisos

GPIO.setmode(GPIO.BCM)

GPIO.setwarnings(False)



# Seção LDR

GPIO.setup(LDR_PIN, GPIO.IN)

# Seção Temperatura

GPIO.setup(TEMP_LED_PIN, GPIO.OUT)

# Seção Bandeiras

GPIO.setup(PIN_VERMELHO, GPIO.OUT)

GPIO.setup(PIN_VERDE, GPIO.OUT)

GPIO.setup(PIN_AMARELO, GPIO.OUT)

# Seção Buzzer

GPIO.setup(BUZZER_PIN, GPIO.OUT)



# Estado inicial: tudo desligado

GPIO.output(TEMP_LED_PIN, GPIO.LOW)

GPIO.output(PIN_VERMELHO, GPIO.LOW)

GPIO.output(PIN_VERDE, GPIO.LOW)

GPIO.output(PIN_AMARELO, GPIO.LOW)

GPIO.output(BUZZER_PIN, GPIO.LOW)



# Teste rápido do buzzer para garantir hardware OK

GPIO.output(BUZZER_PIN, GPIO.HIGH)

sleep(2)

GPIO.output(BUZZER_PIN, GPIO.LOW)





# ==============================

# Funções Auxiliares

# ==============================

def apagar_leds_bandeira():

    GPIO.output(PIN_VERMELHO, GPIO.LOW)

    GPIO.output(PIN_VERDE, GPIO.LOW)

    GPIO.output(PIN_AMARELO, GPIO.LOW)



def acender_cor(cor):

    apagar_leds_bandeira()

    if cor == "vermelha":

        GPIO.output(PIN_VERMELHO, GPIO.HIGH)

    elif cor == "verde":

        GPIO.output(PIN_VERDE, GPIO.HIGH)

    elif cor == "amarela":

        GPIO.output(PIN_AMARELO, GPIO.HIGH)

    else:

        apagar_leds_bandeira()



def pegar_cor_da_api(url):

    try:

        resposta = requests.get(url, params={"nome": "Bandeira"})

        if resposta.status_code == 200:

            texto = resposta.text.lower()

            print("Resposta da API (bandeira):", texto)

            if "verde" in texto:

                return "verde"

            elif "vermelha" in texto:

                return "vermelha"

            elif "amarela" in texto:

                return "amarela"

            else:

                print("Cor não reconhecida na resposta.")

        else:

            print("Erro na requisição bandeira:", resposta.status_code)

    except Exception as e:

        print("Erro ao conectar na API (bandeira):", e)

    return None





# ==============================

# Loop Principal

# ==============================

def main():

    url_api = "https://iot.dei.estg.ipleiria.pt/ti/ti169/PROJETO%20PRAIA%20INTELIGENTE/PROJETO/api.php"



    while True:

        agora = datetime.now().strftime("%Y-%m-%d %H:%M:%S")



        # --- Seção 1: LDR (Dia/Noite) POST ---

        valor_ldr = GPIO.input(LDR_PIN)

        estado_ldr = "Dia" if valor_ldr == GPIO.LOW else "Noite"

        print(f"[{agora}] LDR → {estado_ldr}")

        dados = {

            "valor_Dia": estado_ldr,

            "data_Dia": agora,

            "nome_Dia": "Sensor LDR"

        }

        try:

            resp = requests.post(url_api, data=dados)

            print(f"[{agora}] POST Dia/Noite → {resp.status_code}")

        except Exception as e:

            print("Erro no POST Dia/Noite:", e)



        # --- Seção 2: Temperatura GET + LED ---

        try:

            r = requests.get(url_api, params={"nome": "Tempagua"})

            r.raise_for_status()

            temp = float(r.text.strip().split()[-1])

            print(f"[{agora}] Tempagua → {temp}°C")

            if temp > 20:

                GPIO.output(TEMP_LED_PIN, GPIO.HIGH)

                print("LED Temperatura → ACESO")

            else:

                GPIO.output(TEMP_LED_PIN, GPIO.LOW)

                print("LED Temperatura → APAGADO")

        except Exception as e:

            print("Erro no GET Tempagua ou controlo do LED:", e)



        # --- Seção 3: Bandeiras GET + LED + Buzzer ---

        cor = pegar_cor_da_api(url_api)

        if cor:

            print(f"[{agora}] Bandeira → {cor}")

            acender_cor(cor)

            # Buzzer ON apenas se Vermelha

            if cor == "vermelha":

                GPIO.output(BUZZER_PIN, GPIO.HIGH)

            else:

                GPIO.output(BUZZER_PIN, GPIO.LOW)

        else:

            print(f"[{agora}] Nenhuma cor válida recebida, apagando LEDs de bandeira.")

            apagar_leds_bandeira()

            GPIO.output(BUZZER_PIN, GPIO.LOW)


        # --- Seção 4: Captura de Imagem se Vermelha ---
        # Aguarda 10 segundos para próxima leitura

        sleep(10)

        if cor == "vermelha":

                cap = cv2.VideoCapture(webcam_url)

                ret, frame = cap.read()

                if ret:

                    cv2.imwrite('captura.jpg', frame)

                cap.release()



                url = 'https://iot.dei.estg.ipleiria.pt/ti/ti169/PROJETO%20PRAIA%20INTELIGENTE/PROJETO/api/upload.php'

                files = {'imagem': open('captura.jpg', 'rb')}

                m = requests.post(url, files=files)



                hora = strftime("%Y-%m-%d %H:%M:%S", localtime())

                requests.post('https://iot.dei.estg.ipleiria.pt/ti/ti169/PROJETO%20PRAIA%20INTELIGENTE/PROJETO/api/files/Camera/data.txt', hora)



        else:

            print("Erro na requisição:", r.status_code)



# ==============================

# Execução e limpeza

# ==============================

try:

    main()

except KeyboardInterrupt:

    print("Encerrando...")

finally:

    # Desliga tudo antes de sair

    GPIO.output(TEMP_LED_PIN, GPIO.LOW)

    apagar_leds_bandeira()

    GPIO.output(BUZZER_PIN, GPIO.LOW)

    GPIO.cleanup()

    print("Programa terminado.")

