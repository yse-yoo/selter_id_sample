import cv2
import face_recognition
import os
import sys

# Load the uploaded image from arguments
uploaded_image_path = sys.argv[1]
# Path to pre-registered images (face dataset)
registered_faces_dir = "path/to/registered_faces/"

# Load the uploaded image
uploaded_image = face_recognition.load_image_file(uploaded_image_path)
uploaded_face_encodings = face_recognition.face_encodings(uploaded_image)

if len(uploaded_face_encodings) == 0:
    print("No face detected in the uploaded image.")
    sys.exit(1)

uploaded_face_encoding = uploaded_face_encodings[0]

# Compare with registered faces
matches = []
for filename in os.listdir(registered_faces_dir):
    if filename.endswith('.jpg') or filename.endswith('.png'):
        # Load each registered image
        registered_image_path = os.path.join(registered_faces_dir, filename)
        registered_image = face_recognition.load_image_file(registered_image_path)
        registered_face_encodings = face_recognition.face_encodings(registered_image)

        if len(registered_face_encodings) > 0:
            registered_face_encoding = registered_face_encodings[0]

            # Compare uploaded face with registered face
            match = face_recognition.compare_faces([registered_face_encoding], uploaded_face_encoding)
            if match[0]:
                print(f"Match found: {filename}")
                sys.exit(0)

# If no match is found
print("No match found.")
sys.exit(1)
