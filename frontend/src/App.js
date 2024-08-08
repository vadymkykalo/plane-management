import React from 'react';
import Aircrafts from './components/Aircrafts';
import ServiceRequests from './components/ServiceRequests';
import MaintenanceCompanies from './components/MaintenanceCompanies';
import './App.css';

function App() {
    return (
        <div className="app-container">
            <h1 className="centered-title">Plane Service Management System</h1>
            <Aircrafts />
            <ServiceRequests />
            <MaintenanceCompanies />
        </div>
    );
}

export default App;
