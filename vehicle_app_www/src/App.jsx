import React from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";

// import Login from "./Views/Login";
// import Home from "./Views/Home";
import Dashboard from "./Views/Dashboard";
import Login from "./Views/Login";
import Index from "./Views/Index";
import ProtectedRoutes from "./Utils/ProtectedRoute";
import Register from "./Views/Register";
import PhoneVerification from "./Views/PhoneVerification";
import ForgotPassword from "./Views/ForgotPassword";
import PasswordReset from "./Views/PasswordReset";

const App = () => {

  return (
    <BrowserRouter>
    <Routes>
      <Route path="/dashboard" element={
        <ProtectedRoutes>
          <Dashboard />
        </ProtectedRoutes>} 
      />
      <Route path="login" element={<Login />} />
      <Route path="/" element={<Index />} />
      <Route path="register" element={<Register />} />
      <Route path="verify-phone" element={<PhoneVerification />} />
      <Route path="forgot-password" element={<ForgotPassword />} />
      <Route path="password-reset" element={<PasswordReset />} />
    </Routes>
    </BrowserRouter>
  )
}

export default App
