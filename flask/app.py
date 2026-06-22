from flask import Flask, request, jsonify
import numpy as np
import tensorflow as tf
import joblib

app = Flask(__name__)

# =========================
# LOAD SEMUA MODEL
# =========================

models = {
    'Paracetamol': tf.keras.models.load_model(
        'models/paracetamol.keras'
    ),

    'Amoxicillin': tf.keras.models.load_model(
        'models/amoxicillin.keras'
    ),

    'Vitamin C': tf.keras.models.load_model(
        'models/vitamin_c.keras'
    )
}

# =========================
# LOAD SEMUA SCALER
# =========================

scalers = {
    'Paracetamol': joblib.load(
        'scalers/paracetamol.pkl'
    ),

    'Amoxicillin': joblib.load(
        'scalers/amoxicillin.pkl'
    ),

    'Vitamin C': joblib.load(
        'scalers/vitamin_c.pkl'
    )
}

# =========================
# HOME
# =========================

@app.route('/')
def home():
    return "Flask API Multi Obat Aktif"

# =========================
# PREDICT
# =========================

@app.route('/predict', methods=['POST'])
def predict():

    try:

        obat = request.json.get('obat')
        data = request.json.get('input')

        if obat is None:

            return jsonify({
                'status': 'error',
                'message': 'Nama obat tidak ditemukan'
            })

        if data is None:

            return jsonify({
                'status': 'error',
                'message': 'Input tidak ditemukan'
            })

        if obat not in models:

            return jsonify({
                'status': 'error',
                'message': f'Model untuk {obat} tidak tersedia'
            })

        if len(data) != 14:

            return jsonify({
                'status': 'error',
                'message': 'Model membutuhkan 14 data historis'
            })

        model = models[obat]
        scaler = scalers[obat]

        # =====================
        # PREPROCESS
        # =====================

        input_array = np.array(
            data,
            dtype=np.float32
        ).reshape(-1,1)

        input_scaled = scaler.transform(
            input_array
        )

        input_scaled = input_scaled.reshape(
            1,
            14,
            1
        )

        # =====================
        # PREDIKSI
        # =====================

        prediction = model.predict(
            input_scaled,
            verbose=0
        )

        prediction_real = scaler.inverse_transform(
            prediction
        )

        hasil = float(
            prediction_real[0][0]
        )

        hasil_final = int(
            round(hasil)
        )

        rekomendasi = int(
            round(
                hasil_final * 1.2
            )
        )

        return jsonify({

            'status': 'success',

            'obat': obat,

            'prediction': hasil_final,

            'rekomendasi': rekomendasi

        })

    except Exception as e:

        return jsonify({

            'status': 'error',

            'message': str(e)

        })

# =========================
# RUN
# =========================

if __name__ == '__main__':

    app.run(
        host='0.0.0.0',
        port=5000,
        debug=True
    )