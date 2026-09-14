const apiBaseUrl = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000";

export type ApiProblem = {
  title?: string;
  detail?: string;
  message?: string;
  errors?: Record<string, string[]>;
};

function xsrfToken(): string | undefined {
  if (typeof document === "undefined") return undefined;
  const cookie = document.cookie.split("; ").find((entry) => entry.startsWith("XSRF-TOKEN="));
  return cookie ? decodeURIComponent(cookie.slice("XSRF-TOKEN=".length)) : undefined;
}

export async function initializeCsrf(): Promise<void> {
  const response = await fetch(`${apiBaseUrl}/sanctum/csrf-cookie`, {
    credentials: "include",
    headers: { Accept: "application/json" },
  });
  if (!response.ok && response.status !== 204) throw new Error("Unable to initialize a secure session.");
}

export async function apiRequest<T>(path: string, init: RequestInit = {}): Promise<T> {
  const csrf = xsrfToken();
  const response = await fetch(`${apiBaseUrl}${path}`, {
    ...init,
    credentials: "include",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
      ...(csrf ? { "X-XSRF-TOKEN": csrf } : {}),
      ...init.headers,
    },
  });

  if (!response.ok) {
    const problem = await response.json().catch(() => ({})) as ApiProblem;
    const message = problem.detail ?? problem.message ?? problem.title ?? "The request could not be completed.";
    const error = new Error(message) as Error & { problem: ApiProblem; status: number };
    error.problem = problem;
    error.status = response.status;
    throw error;
  }

  if (response.status === 204) return undefined as T;
  return response.json() as Promise<T>;
}
