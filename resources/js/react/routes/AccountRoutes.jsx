import { Routes, Route, Navigate } from "react-router-dom";
import AccountPage from "../pages/AccountPage";
import EditAccountPage from "../pages/EditAccountPage";
import { useAuth } from "../auth/useAuth";
import Auth from "../pages/Auth";

function PrivateRoute({ children }) {
  const { user, loading } = useAuth();

  if (loading) return null; // hoặc loading spinner

  return user ? children : <Navigate to="/login" replace />;
}


export default function AccountRoutes() {
  return (
    <Routes>
      <Route path="/login" element={<Auth />} />
      <Route path="/register" element={<Auth />} />

      <Route path="/account" element={<PrivateRoute><AccountPage /></PrivateRoute>} />
      <Route path="/account/edit" element={<PrivateRoute><EditAccountPage /></PrivateRoute>} />

      <Route path="*" element={<Navigate to="/" />} />
    </Routes>
  );
}
