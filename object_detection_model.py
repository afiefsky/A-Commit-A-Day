import tensorflow as tf
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Conv2D, MaxPooling2D, Flatten
from tensorflow.keras.preprocessing.image import ImageDataGenerator
import numpy as np
import cv2

# Define the model
def create_model():
    model = Sequential([
        Conv2D(32, (3, 3), activation='relu', input_shape=(128, 128, 3)),
        MaxPooling2D((2, 2)),
        Conv2D(64, (3, 3), activation='relu'),
        MaxPooling2D((2, 2)),
        Conv2D(128, (3, 3), activation='relu'),
        MaxPooling2D((2, 2)),
        Flatten(),
        Dense(512, activation='relu'),
        Dense(1, activation='sigmoid')  # Binary classification (object vs. no object)
    ])
    model.compile(optimizer='adam',
                  loss='binary_crossentropy',
                  metrics=['accuracy'])
    return model

# Prepare the data
def prepare_data():
    datagen = ImageDataGenerator(rescale=1./255, validation_split=0.2)
    train_generator = datagen.flow_from_directory(
        'data/',  # Directory with training data
        target_size=(128, 128),
        batch_size=32,
        class_mode='binary',
        subset='training'
    )
    validation_generator = datagen.flow_from_directory(
        'data/',  # Directory with validation data
        target_size=(128, 128),
        batch_size=32,
        class_mode='binary',
        subset='validation'
    )
    return train_generator, validation_generator

# Train the model
def train_model(model, train_generator, validation_generator):
    model.fit(
        train_generator,
        epochs=10,
        validation_data=validation_generator
    )

# Main execution
if __name__ == "__main__":
    model = create_model()
    train_gen, val_gen = prepare_data()
    train_model(model, train_gen, val_gen)

    # Save the model
    model.save('object_detection_model.h5')
