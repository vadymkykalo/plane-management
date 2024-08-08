import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './Aircrafts.css'; // Подключаем файл стилей

function Aircrafts() {
    const [aircrafts, setAircrafts] = useState([]);
    const [model, setModel] = useState('');
    const [serialNumber, setSerialNumber] = useState('');
    const [registration, setRegistration] = useState('');

    useEffect(() => {
        fetchAircrafts();
    }, []);

    const fetchAircrafts = async () => {
        try {
            const response = await axios.get('http://localhost:8080/api/aircrafts');
            setAircrafts(response.data);
        } catch (error) {
            console.error('Error fetching aircrafts:', error);
        }
    };

    const createAircraft = async () => {
        try {
            const response = await axios.post('http://localhost:8080/api/aircrafts', {
                model,
                serial_number: serialNumber,
                registration
            });
            setAircrafts([...aircrafts, response.data]);
        } catch (error) {
            console.error('Error creating aircraft:', error);
        }
    };

    const handleEdit = (aircraft) => {
        setModel(aircraft.model);
        setSerialNumber(aircraft.serial_number);
        setRegistration(aircraft.registration);
    };

    const handleDelete = async (id) => {
        await axios.delete(`http://localhost:8080/api/aircrafts/${id}`);
        fetchAircrafts();  // Обновление списка после удаления
    };

    return (
        <div className="aircraft-container">
            <h2>Aircrafts</h2>
            <form onSubmit={createAircraft} className="input-group">
                <input
                    type="text"
                    placeholder="Model"
                    value={model}
                    onChange={(e) => setModel(e.target.value)}
                />
                <input
                    type="text"
                    placeholder="Serial Number"
                    value={serialNumber}
                    onChange={(e) => setSerialNumber(e.target.value)}
                />
                <input
                    type="text"
                    placeholder="Registration"
                    value={registration}
                    onChange={(e) => setRegistration(e.target.value)}
                />
                <button type="submit">Create</button>
            </form>
            <ul className="aircraft-list">
                {aircrafts.map((aircraft) => (
                    <li key={aircraft.id} className="aircraft-item">
                        <span>{aircraft.model} - {aircraft.serial_number} - {aircraft.registration}</span>
                        <div className="button-group">
                            <button className="edit-button" onClick={() => handleEdit(aircraft)}>Edit</button>
                            <button className="delete-button" onClick={() => handleDelete(aircraft.id)}>Delete</button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default Aircrafts;
