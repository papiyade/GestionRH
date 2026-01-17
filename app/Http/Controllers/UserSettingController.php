<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSettingController extends Controller
{
    /**
     * Affiche la page des paramètres
     */
    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    /**
     * Mise à jour du profil (nom, email, téléphone, photo)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:30',
            'photo_profile_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload photo si présente
        if ($request->hasFile('photo_profile_path')) {

            $photoName = time() . '.' . $request->photo_profile_path->extension();

            // Sauvegarde dans /public/uploads/users
            $request->photo_profile_path->move(public_path('uploads/users'), $photoName);

            // Mise à jour du champ
            $user->photo_profile_path = 'uploads/users/' . $photoName;
        }

        // Mise à jour informations
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'photo_profile_path' => $user->photo_profile_path,
        ]);

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Mise à jour du mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Vérifier que l'ancien mot de passe est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.',
            ]);
        }

        // Mettre à jour avec le nouveau mot de passe
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Mot de passe mis à jour.');
    }

    /**
     * Affichage de la page préférences
     */
public function preferences()
{
    $user = Auth::user();
    
    // S'assurer que les préférences existent
    if (!isset($user->preferences['appearance']['theme'])) {
        $user->preferences = array_merge($user->preferences ?? [], [
            'appearance' => [
                'theme' => 'light',
                'density' => 'comfortable',
                'animations' => true,
            ]
        ]);
        $user->save();
    }
    
    return view('settings.preferences');
}

    /**
     * Mise à jour des préférences générales
     */
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'language' => 'required|in:fr,en,es',
            'timezone' => 'required|string',
            'date_format' => 'required|in:d/m/Y,m/d/Y,Y-m-d',
        ]);

        $user = Auth::user();
        
        // Stocker les préférences dans un champ JSON ou table séparée
        $user->preferences = array_merge($user->preferences ?? [], [
            'language' => $request->language,
            'timezone' => $request->timezone,
            'date_format' => $request->date_format,
        ]);
        
        $user->save();

        return back()->with('success', 'Préférences mises à jour avec succès.');
    }

    /**
     * Mise à jour des notifications
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $user->preferences = array_merge($user->preferences ?? [], [
            'notifications' => [
                'messages' => $request->has('notif_messages'),
                'projects' => $request->has('notif_projects'),
                'tasks' => $request->has('notif_tasks'),
                'newsletter' => $request->has('notif_newsletter'),
            ]
        ]);
        
        $user->save();

        return back()->with('success', 'Notifications mises à jour avec succès.');
    }

    /**
     * Mise à jour de la confidentialité
     */
    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        
        $user->preferences = array_merge($user->preferences ?? [], [
            'privacy' => [
                'public_profile' => $request->has('public_profile'),
                'show_email' => $request->has('show_email'),
                'online_status' => $request->has('online_status'),
            ]
        ]);
        
        $user->save();

        return back()->with('success', 'Paramètres de confidentialité mis à jour.');
    }

    /**
     * Mise à jour de l'apparence
     */
    public function updateAppearance(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark,auto',
            'density' => 'required|in:comfortable,compact,spacious',
        ]);

        $user = Auth::user();
        
        $user->preferences = array_merge($user->preferences ?? [], [
            'appearance' => [
                'theme' => $request->theme,
                'density' => $request->density,
                'animations' => $request->has('animations'),
            ]
        ]);
        
        $user->save();

        return back()->with('success', 'Apparence mise à jour avec succès.');
    }

    /**
     * Suppression du compte utilisateur
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'confirmation' => 'required|string',
        ]);

        $user = Auth::user();
        $expectedText = 'delete/my-account-' . strtolower($user->name);

        // Vérifier que le texte de confirmation correspond
        if ($request->confirmation !== $expectedText) {
            return back()->withErrors([
                'confirmation' => 'Le texte de confirmation ne correspond pas.',
            ]);
        }

        // Supprimer toutes les données associées (à adapter selon votre structure)
        // $user->projects()->delete();
        // $user->tasks()->delete();
        // $user->messages()->delete();
        // etc.

        // Déconnecter l'utilisateur
        Auth::logout();

        // Supprimer le compte
        $user->delete();

        // Invalider la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Rediriger vers la page d'accueil
        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }
}
