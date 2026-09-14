"use client";

import Link from "next/link";
import { useRouter } from "next/navigation";
import { FormEvent, useState } from "react";
import { apiRequest, initializeCsrf, type ApiProblem } from "@/lib/api";

type AuthFormProps = {
  mode: "login" | "register";
  returnTo?: string;
};

function safeReturnTo(value?: string) {
  return value?.startsWith("/") && !value.startsWith("//") ? value : "/";
}

export function AuthForm({ mode, returnTo }: AuthFormProps) {
  const router = useRouter();
  const [pending, setPending] = useState(false);
  const [error, setError] = useState("");
  const [fieldErrors, setFieldErrors] = useState<Record<string, string[]>>({});

  const submit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    setPending(true);
    setError("");
    setFieldErrors({});
    const formData = new FormData(event.currentTarget);
    const payload = Object.fromEntries(formData.entries());

    try {
      await initializeCsrf();
      await apiRequest(`/api/v1/auth/${mode}`, { method: "POST", body: JSON.stringify(payload) });
      router.push(safeReturnTo(returnTo));
      router.refresh();
    } catch (caught) {
      const requestError = caught as Error & { problem?: ApiProblem };
      setError(requestError.message);
      setFieldErrors(requestError.problem?.errors ?? {});
    } finally {
      setPending(false);
    }
  };

  const isRegister = mode === "register";

  return (
    <form onSubmit={(event) => void submit(event)} className="mt-8 space-y-5" noValidate>
      {isRegister && <label className="block text-sm font-semibold">Name<input name="name" required autoComplete="name" aria-describedby={fieldErrors.name ? "name-error" : undefined} className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] px-4 font-normal outline-none focus:border-[#0c2340]" />{fieldErrors.name && <span id="name-error" className="mt-1 block text-sm text-[#b9342a]">{fieldErrors.name[0]}</span>}</label>}
      <label className="block text-sm font-semibold">Email<input name="email" type="email" required autoComplete="email" aria-describedby={fieldErrors.email ? "email-error" : undefined} className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] px-4 font-normal outline-none focus:border-[#0c2340]" />{fieldErrors.email && <span id="email-error" className="mt-1 block text-sm text-[#b9342a]">{fieldErrors.email[0]}</span>}</label>
      <div><label htmlFor="password" className="block text-sm font-semibold">Password</label><input id="password" name="password" type="password" required minLength={12} maxLength={72} autoComplete={isRegister ? "new-password" : "current-password"} aria-describedby={`${isRegister ? "password-help" : ""}${fieldErrors.password ? " password-error" : ""}`.trim() || undefined} className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] px-4 outline-none focus:border-[#0c2340]" />{isRegister && <span id="password-help" className="mt-1 block text-xs leading-5 text-[#66778b]">12–72 characters with upper and lowercase letters, a number, and a symbol.</span>}{fieldErrors.password && <span id="password-error" className="mt-1 block text-sm text-[#b9342a]">{fieldErrors.password[0]}</span>}</div>
      {isRegister && <label className="block text-sm font-semibold">Confirm password<input name="password_confirmation" type="password" required minLength={12} maxLength={72} autoComplete="new-password" className="mt-2 min-h-12 w-full rounded-lg border border-[#bdcbd8] px-4 font-normal outline-none focus:border-[#0c2340]" /></label>}
      {error && <p role="alert" className="rounded-lg bg-[#fff0ed] p-3 text-sm text-[#962d24]">{error}</p>}
      <button type="submit" disabled={pending} className="min-h-12 w-full rounded-lg bg-[#f06452] px-5 font-bold text-white hover:bg-[#d84b3b] disabled:cursor-wait disabled:opacity-60">{pending ? "Please wait…" : isRegister ? "Create account" : "Sign in"}</button>
      <p className="text-center text-sm text-[#53647a]">{isRegister ? "Already have an account?" : "New to Wanderline?"} <Link className="font-bold text-[#0c2340] underline-offset-4 hover:underline" href={`${isRegister ? "/login" : "/register"}${returnTo ? `?returnTo=${encodeURIComponent(safeReturnTo(returnTo))}` : ""}`}>{isRegister ? "Sign in" : "Create one"}</Link></p>
    </form>
  );
}
