import React, { useMemo, useState } from 'react';
import {
  ActivityIndicator,
  Alert,
  SafeAreaView,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View,
} from 'react-native';
import { StatusBar } from 'expo-status-bar';
import axios from 'axios';

const MODULES = [
  {
    key: 'facility',
    title: 'تاسیسات',
    endpoint: '/api/v1/facility-requests',
    fields: [
      { key: 'location', label: 'محل', placeholder: 'سالن / اتاق' },
      { key: 'description', label: 'شرح مشکل', placeholder: 'توضیح خرابی' },
      { key: 'priority', label: 'اولویت', placeholder: 'low/medium/high/urgent' },
    ],
  },
  {
    key: 'it',
    title: 'فناوری اطلاعات',
    endpoint: '/api/v1/it-requests',
    fields: [
      { key: 'problem_description', label: 'شرح مشکل IT', placeholder: 'پرینتر / شبکه / سیستم' },
      { key: 'priority', label: 'اولویت', placeholder: 'low/medium/high/urgent' },
    ],
  },
  {
    key: 'vehicle',
    title: 'نقلیه',
    endpoint: '/api/v1/vehicle-requests',
    fields: [
      { key: 'trip_purpose', label: 'هدف سفر', placeholder: 'بازرسی / انتقال' },
      { key: 'origin', label: 'مبدأ', placeholder: 'مرکز بهداشت' },
      { key: 'destination', label: 'مقصد', placeholder: 'روستا / مرکز' },
      { key: 'departure_datetime', label: 'زمان حرکت', placeholder: '2026-08-05 08:30:00' },
      { key: 'passenger_count', label: 'تعداد سرنشین', placeholder: '2' },
    ],
  },
];

export default function App() {
  const [apiBase, setApiBase] = useState('http://127.0.0.1:8000');
  const [email, setEmail] = useState('admin@saveh.local');
  const [password, setPassword] = useState('password');
  const [token, setToken] = useState('');
  const [userName, setUserName] = useState('');
  const [active, setActive] = useState(MODULES[0].key);
  const [form, setForm] = useState({});
  const [loading, setLoading] = useState(false);
  const [lastResponse, setLastResponse] = useState('');

  const module = useMemo(
    () => MODULES.find((m) => m.key === active) || MODULES[0],
    [active]
  );

  const client = useMemo(() => {
    const instance = axios.create({
      baseURL: apiBase.replace(/\/$/, ''),
      timeout: 15000,
      validateStatus: () => true,
    });
    if (token) {
      instance.defaults.headers.common.Authorization = `Bearer ${token}`;
    }
    return instance;
  }, [apiBase, token]);

  const onChange = (key, value) => {
    setForm((prev) => ({ ...prev, [key]: value }));
  };

  const login = async () => {
    setLoading(true);
    setLastResponse('');
    try {
      const { data, status } = await client.post('/api/v1/auth/login', {
        email,
        password,
        device_name: 'saveh-mobile',
      });
      setLastResponse(JSON.stringify({ status, data }, null, 2));
      if (status >= 200 && status < 300 && data?.token) {
        setToken(data.token);
        setUserName(data?.user?.name || email);
        Alert.alert('ورود موفق', 'توکن دریافت شد');
      } else {
        Alert.alert('خطا', data?.message || `کد ${status}`);
      }
    } catch (error) {
      const message = error?.message || 'خطای ناشناخته';
      setLastResponse(message);
      Alert.alert('خطا در ارتباط', message);
    } finally {
      setLoading(false);
    }
  };

  const logout = async () => {
    if (!token) return;
    setLoading(true);
    try {
      await client.post('/api/v1/auth/logout');
    } finally {
      setToken('');
      setUserName('');
      setLoading(false);
      Alert.alert('خروج', 'نشست موبایل بسته شد');
    }
  };

  const submit = async () => {
    if (!token) {
      Alert.alert('نیاز به ورود', 'اول وارد شوید');
      return;
    }

    setLoading(true);
    setLastResponse('');
    try {
      const payload = { ...form };
      if (payload.passenger_count) {
        payload.passenger_count = Number(payload.passenger_count);
      }

      const { data, status } = await client.post(module.endpoint, payload);
      setLastResponse(JSON.stringify({ status, data }, null, 2));

      if (status >= 200 && status < 300) {
        Alert.alert('ثبت شد', `${module.title} با موفقیت ارسال شد`);
        setForm({});
      } else {
        Alert.alert('پاسخ سرور', data?.message || `کد ${status}`);
      }
    } catch (error) {
      const message = error?.message || 'خطای ناشناخته';
      setLastResponse(message);
      Alert.alert('خطا در ارتباط', message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <SafeAreaView style={styles.safe}>
      <StatusBar style="dark" />
      <ScrollView contentContainerStyle={styles.container}>
        <Text style={styles.brand}>مرکز بهداشت ساوه</Text>
        <Text style={styles.subtitle}>اپ میدانی تاسیسات / IT / نقلیه + Sanctum</Text>

        <View style={styles.card}>
          <Text style={styles.label}>آدرس API</Text>
          <TextInput style={styles.input} value={apiBase} onChangeText={setApiBase} autoCapitalize="none" />

          {!token ? (
            <>
              <Text style={styles.label}>ایمیل</Text>
              <TextInput style={styles.input} value={email} onChangeText={setEmail} autoCapitalize="none" />
              <Text style={styles.label}>رمز عبور</Text>
              <TextInput style={styles.input} value={password} onChangeText={setPassword} secureTextEntry />
              <TouchableOpacity style={styles.button} onPress={login} disabled={loading}>
                {loading ? <ActivityIndicator color="#fff" /> : <Text style={styles.buttonText}>ورود و دریافت توکن</Text>}
              </TouchableOpacity>
            </>
          ) : (
            <>
              <Text style={styles.sectionTitle}>وارد شده: {userName || email}</Text>
              <Text style={styles.mono}>Bearer {token.slice(0, 18)}...</Text>
              <TouchableOpacity style={[styles.button, styles.buttonGhost]} onPress={logout} disabled={loading}>
                <Text style={styles.buttonGhostText}>خروج</Text>
              </TouchableOpacity>
            </>
          )}
        </View>

        <View style={styles.tabs}>
          {MODULES.map((m) => (
            <TouchableOpacity
              key={m.key}
              style={[styles.tab, active === m.key && styles.tabActive]}
              onPress={() => {
                setActive(m.key);
                setForm({});
                setLastResponse('');
              }}
            >
              <Text style={[styles.tabText, active === m.key && styles.tabTextActive]}>{m.title}</Text>
            </TouchableOpacity>
          ))}
        </View>

        <View style={styles.card}>
          <Text style={styles.sectionTitle}>فرم {module.title}</Text>
          {module.fields.map((field) => (
            <View key={field.key} style={styles.field}>
              <Text style={styles.label}>{field.label}</Text>
              <TextInput
                style={[
                  styles.input,
                  field.key.includes('description') || field.key.includes('purpose') ? styles.textarea : null,
                ]}
                value={form[field.key] || ''}
                onChangeText={(v) => onChange(field.key, v)}
                placeholder={field.placeholder}
                multiline={field.key.includes('description') || field.key.includes('purpose')}
              />
            </View>
          ))}

          <TouchableOpacity style={styles.button} onPress={submit} disabled={loading || !token}>
            {loading ? <ActivityIndicator color="#fff" /> : <Text style={styles.buttonText}>ارسال درخواست</Text>}
          </TouchableOpacity>
        </View>

        {!!lastResponse && (
          <View style={styles.card}>
            <Text style={styles.sectionTitle}>پاسخ</Text>
            <Text style={styles.mono}>{lastResponse}</Text>
          </View>
        )}
      </ScrollView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safe: { flex: 1, backgroundColor: '#f5f2eb' },
  container: { padding: 16, gap: 12 },
  brand: { fontSize: 24, fontWeight: '700', color: '#1a392b', textAlign: 'right' },
  subtitle: { fontSize: 13, color: '#5d7166', textAlign: 'right', marginBottom: 8 },
  card: {
    backgroundColor: '#fff',
    borderRadius: 18,
    padding: 14,
    borderWidth: 1,
    borderColor: 'rgba(44,53,48,0.08)',
  },
  label: { color: '#3c4a43', marginBottom: 6, textAlign: 'right', fontSize: 13 },
  input: {
    borderWidth: 1,
    borderColor: '#d9cdb5',
    borderRadius: 12,
    paddingHorizontal: 12,
    paddingVertical: 10,
    backgroundColor: '#fbfaf7',
    textAlign: 'right',
    marginBottom: 10,
  },
  textarea: { minHeight: 80 },
  tabs: { flexDirection: 'row-reverse', gap: 8 },
  tab: {
    flex: 1,
    backgroundColor: '#fff',
    borderRadius: 999,
    paddingVertical: 10,
    borderWidth: 1,
    borderColor: '#d9cdb5',
  },
  tabActive: { backgroundColor: '#2d6b4b', borderColor: '#2d6b4b' },
  tabText: { textAlign: 'center', color: '#2c3530', fontWeight: '600' },
  tabTextActive: { color: '#fff' },
  sectionTitle: { fontSize: 16, fontWeight: '700', color: '#1a392b', textAlign: 'right', marginBottom: 10 },
  button: {
    backgroundColor: '#2d6b4b',
    borderRadius: 999,
    paddingVertical: 14,
    alignItems: 'center',
    marginTop: 4,
  },
  buttonText: { color: '#fff', fontWeight: '700' },
  buttonGhost: {
    backgroundColor: '#fff',
    borderWidth: 1,
    borderColor: '#2d6b4b',
  },
  buttonGhostText: { color: '#2d6b4b', fontWeight: '700' },
  field: { marginBottom: 4 },
  mono: { fontFamily: 'monospace', fontSize: 11, color: '#333', textAlign: 'left' },
});
