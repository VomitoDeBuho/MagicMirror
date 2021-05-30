import sys
import picamera
import numpy as np
import os
import mysql.connector
from smbus2 import SMBus
from PyMLX90614.mlx90614 import MLX90614
from fr_package.face_recognition import api as face_recognition

mydb = mysql.connector.connect(
  host="mysql-5705.dinaserver.com",
  user="ablazquez",
  password="Lexcreeper123",
  database="registresFacials"
)

mycursor = mydb.cursor()
sql = "INSERT INTO main (nom, temp) VALUES (%s, %s)"

def send_to_console(message):
        try:
                print(message)
        except Exception:
                pass
        sys.stdout.flush()

directori = '/Fotos/'
contingut = os.listdir(directori)
imatges = []
for fitxer in contingut:
    if os.path.isfile(os.path.join(directori, fitxer)) and fitxer.endswith('.jpg'):
        imatges.append(fitxer)
camera = picamera.PiCamera()
camera.resolution = (640, 480)
output = np.empty((480, 640, 3), dtype=np.uint8)
bus = SMBus(1)
sensor = MLX90614(bus, address=0x5A)

cares = []
for j in range(len(imatges)):
    cara = face_recognition.load_image_file(directori+imatges[j])
    cares.append(face_recognition.face_encodings(cara)[0])

face_locations = []
face_encodings = []

while True:
    camera.capture(output, format="rgb")
    face_locations = face_recognition.face_locations(output)
    face_encodings = face_recognition.face_encodings(output, face_locations)
    for face_encoding in face_encodings:
        match = []
        for i in range(len(cares)):
            match.append(face_recognition.compare_faces([cares[i]], face_encoding))
        for i in range(len(match)):
            if match[i][0]:
                print("Benvigut: {}!".format(imatges[i].split(".")[0]))
                str_split = str(sensor.get_object_1()).split(".")
                #Comprovem que la temperatura sigui la correcta, si ho es, pujara les dades
                if sensor.get_object_1() > 34.5 and sensor.get_object_1() < 37.5:
                    if len(str_split[1]) > 1:
                        send_to_console("La teva temperatura és correcte, has donat {} graus".format(str_split[0] + "." + str_split[1][0:2]))
                    else:
                        send_to_console("La teva temperatura és correcte, has donat {} graus".format(str_split[0] + "." + str_split[1][0:len(str_split[1])]))
                    val = (imatges[i].split(".")[0], sensor.get_object_1())
                    mycursor.execute(sql, val)
                    mydb.commit()
                else:

                    if len(str_split[1]) > 1:
                        send_to_console("La teva temperatura NO és correcte, has donat {} graus".format(str_split[0] + "." + str_split[1][0:2]))
                    else:
                        send_to_console("La teva temperatura NO és correcte, has donat {} graus".format(str_split[0] + "." + str_split[1][0:len(str_split[1])]))



