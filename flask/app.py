from flask import Flask, request, jsonify
from tensorflow.keras.models import load_model

import numpy as np
import joblib

app = Flask(__name__)

model = load_model(
    "model_apotek_lstm.keras"
)

scaler_x = joblib.load(
    "scaler_x.pkl"
)

scaler_y = joblib.load(
    "scaler_y.pkl"
)

@app.route('/predict', methods=['POST'])
def predict():

    try:

        data = request.get_json()

        x = np.array(
            data['input']
        )

        x = scaler_x.transform(
            x.reshape(-1,2)
        )

        x = x.reshape(
            1,
            1,
            2
        )

        pred = model.predict(
            x,
            verbose=0
        )

        pred = scaler_y.inverse_transform(
            pred
        )

        return jsonify({

            "status": "success",

            "prediction": float(
                pred[0][0]
            )

        })

    except Exception as e:

        return jsonify({

            "status": "error",

            "message": str(e)

        })

if __name__ == "__main__":

    app.run(
        host="0.0.0.0",
        port=5000,
        debug=True
    )