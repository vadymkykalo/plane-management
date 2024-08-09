import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './Aircrafts.css';

function Aircrafts() {
    const [aircrafts, setAircrafts] = useState([]);
    const [model, setModel] = useState('');
    const [serialNumber, setSerialNumber] = useState('');
    const [registration, setRegistration] = useState('');
    const [maintenanceHistory, setMaintenanceHistory] = useState([]);
    const [selectedAircraftId, setSelectedAircraftId] = useState(null);
    const [historyLoaded, setHistoryLoaded] = useState(false);
    const [editingAircraftId, setEditingAircraftId] = useState(null);

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

    const fetchMaintenanceHistory = async (aircraftId) => {
        try {
            if (selectedAircraftId === aircraftId) {
                setSelectedAircraftId(null);
                setMaintenanceHistory([]);
                setHistoryLoaded(false);
            } else {
                const response = await axios.get(`http://localhost:8080/api/aircrafts/${aircraftId}/maintenance_history`);
                setMaintenanceHistory(response.data);
                setSelectedAircraftId(aircraftId);
                setHistoryLoaded(true);
            }
        } catch (error) {
            console.error('Error fetching maintenance history:', error);
            setHistoryLoaded(true);
        }
    };

    const createOrUpdateAircraft = async (e) => {
        e.preventDefault();

        try {
            if (editingAircraftId) {
                await axios.put(`http://localhost:8080/api/aircrafts/${editingAircraftId}`, {
                    model,
                    serial_number: serialNumber,
                    registration
                });
            } else {
                const response = await axios.post('http://localhost:8080/api/aircrafts', {
                    model,
                    serial_number: serialNumber,
                    registration
                });
                setAircrafts([...aircrafts, response.data]);
            }
            resetForm();
            fetchAircrafts();
        } catch (error) {
            console.error('Error creating/updating aircraft:', error);
        }
    };

    const resetForm = () => {
        setModel('');
        setSerialNumber('');
        setRegistration('');
        setEditingAircraftId(null);
    };

    const handleEdit = (aircraft) => {
        setModel(aircraft.model);
        setSerialNumber(aircraft.serial_number);
        setRegistration(aircraft.registration);
        setEditingAircraftId(aircraft.id);
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete(`http://localhost:8080/api/aircrafts/${id}`);
            fetchAircrafts();
        } catch (error) {
            console.error('Error deleting aircraft:', error);
        }
    };

    return (
        <div className="aircraft-container">
            <h2>Aircraft Management</h2>
            <form onSubmit={createOrUpdateAircraft} className="input-group">
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
                <button type="submit">{editingAircraftId ? 'Update' : 'Create'}</button>
            </form>
            <ul className="aircraft-list">
                {aircrafts.map((aircraft) => (
                    <li key={aircraft.id} className="aircraft-item">
                        <span>{aircraft.model} - {aircraft.serial_number} - {aircraft.registration}</span>
                        <div className="button-group">
                            <button className="edit-button" onClick={() => handleEdit(aircraft)}>Edit</button>
                            <button className="history-button" onClick={() => fetchMaintenanceHistory(aircraft.id)}>Companies history</button>
                            <button className="delete-button" onClick={() => handleDelete(aircraft.id)}>Delete</button>
                        </div>
                        {selectedAircraftId === aircraft.id && (
                            <div className="maintenance-history">
                                <h3>Maintenance History</h3>
                                {maintenanceHistory.length > 0 ? (
                                    <ul>
                                        {maintenanceHistory.map(historyItem => (
                                            <li key={historyItem.id}>
                                                <strong>{historyItem.maintenance_company.name}</strong><br/>
                                                Contact: {historyItem.maintenance_company.contact}<br/>
                                                Specialization: {historyItem.maintenance_company.specialization}<br/>
                                            </li>
                                        ))}
                                    </ul>
                                ) : (
                                    historyLoaded && <p>No maintenance history available for this aircraft.</p>
                                )}
                            </div>
                        )}
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default Aircrafts;
